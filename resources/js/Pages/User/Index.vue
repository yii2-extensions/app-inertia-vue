<script setup>
import { ref, watch } from 'vue'
import { Head, router } from '@inertiajs/vue3'

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
    pagination: {
        type: Object,
        default: () => ({ totalCount: 0, pageSize: 10, currentPage: 1, pageCount: 1 }),
    },
    sort: {
        type: Object,
        default: () => ({ attributes: {} }),
    },
    filters: {
        type: Object,
        default: () => ({ username: '', email: '', status: '' }),
    },
})

const STATUS_ACTIVE = 10
const STATUS_INACTIVE = 9
const STATUS_DELETED = 0

const statusLabels = {
    [STATUS_ACTIVE]: { label: 'Active', class: 'bg-success' },
    [STATUS_INACTIVE]: { label: 'Inactive', class: 'bg-warning text-dark' },
    [STATUS_DELETED]: { label: 'Deleted', class: 'bg-danger' },
}

const filterUsername = ref(props.filters.username || '')
const filterEmail = ref(props.filters.email || '')
const filterStatus = ref(props.filters.status ?? '')

let debounceTimer = null

const applyFilters = () => {
    clearTimeout(debounceTimer)
    debounceTimer = setTimeout(() => {
        const params = {}

        if (filterUsername.value) {
            params['UserSearch[username]'] = filterUsername.value
        }
        if (filterEmail.value) {
            params['UserSearch[email]'] = filterEmail.value
        }
        if (filterStatus.value !== '') {
            params['UserSearch[status]'] = filterStatus.value
        }

        router.get('/user/index', params, {
            preserveState: true,
            preserveScroll: true,
        })
    }, 300)
}

watch([filterUsername, filterEmail, filterStatus], applyFilters)

const sortBy = (attribute) => {
    const currentOrder = props.sort.attributes[attribute]
    let sortParam

    if (currentOrder === 4) {
        // SORT_ASC = 4 -> flip to desc
        sortParam = `-${attribute}`
    } else {
        sortParam = attribute
    }

    const params = { sort: sortParam }

    if (filterUsername.value) {
        params['UserSearch[username]'] = filterUsername.value
    }
    if (filterEmail.value) {
        params['UserSearch[email]'] = filterEmail.value
    }
    if (filterStatus.value !== '') {
        params['UserSearch[status]'] = filterStatus.value
    }

    router.get('/user/index', params, {
        preserveState: true,
        preserveScroll: true,
    })
}

const goToPage = (page) => {
    const params = { page }

    if (filterUsername.value) {
        params['UserSearch[username]'] = filterUsername.value
    }
    if (filterEmail.value) {
        params['UserSearch[email]'] = filterEmail.value
    }
    if (filterStatus.value !== '') {
        params['UserSearch[status]'] = filterStatus.value
    }

    const currentSort = Object.entries(props.sort.attributes)[0]
    if (currentSort) {
        params.sort = currentSort[1] === 3 ? `-${currentSort[0]}` : currentSort[0]
    }

    router.get('/user/index', params, {
        preserveState: true,
        preserveScroll: true,
    })
}

const sortIcon = (attribute) => {
    const order = props.sort.attributes[attribute]
    if (order === 4) return ' \u25B2'
    if (order === 3) return ' \u25BC'
    return ''
}

const formatDate = (timestamp) => {
    if (!timestamp) return ''
    const d = new Date(timestamp * 1000)
    const day = String(d.getDate()).padStart(2, '0')
    const month = String(d.getMonth() + 1).padStart(2, '0')
    const year = d.getFullYear()
    return `${day}/${month}/${year}`
}

const getStatus = (status) => {
    return statusLabels[status] || { label: 'Unknown', class: 'bg-secondary' }
}

const pages = () => {
    const result = []
    for (let i = 1; i <= props.pagination.pageCount; i++) {
        result.push(i)
    }
    return result
}
</script>

<template>
    <Head title="Users" />

    <div class="site-users d-flex align-items-center justify-content-center">
        <div class="card border-0 overflow-hidden login-split-card users-split-card w-100">
            <div class="row g-0">

                <!-- Brand panel -->
                <div class="col-md-4 d-none d-md-flex login-brand-panel text-white">
                    <div class="d-flex flex-column justify-content-between p-4 p-lg-4 w-100">
                        <div>
                            <img src="/images/yii3_full_white_for_dark.svg" alt="Yii Framework" class="mb-4" height="36" />
                        </div>
                        <div>
                            <h1 class="fw-bold mb-3 login-brand-title">User<br />Directory</h1>
                            <p class="opacity-75 mb-0 login-brand-text">
                                Browse, filter, and sort registered users. Use the search fields to find specific accounts.
                            </p>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-white bg-opacity-25 rounded-pill px-3 py-2">
                                    {{ pagination.totalCount }} {{ pagination.totalCount === 1 ? 'user' : 'users' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table panel -->
                <div class="col-md-8">
                    <div class="p-4 p-lg-4">

                        <!-- Mobile header -->
                        <div class="d-md-none text-center mb-4">
                            <h1 class="h3 fw-bold mb-1">Users</h1>
                            <p class="text-body-secondary small mb-0">Browse and filter registered users</p>
                        </div>

                        <div class="users-table-wrapper">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="#" @click.prevent="sortBy('username')">
                                                USERNAME{{ sortIcon('username') }}
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" @click.prevent="sortBy('email')">
                                                EMAIL{{ sortIcon('email') }}
                                            </a>
                                        </th>
                                        <th class="col-status">
                                            <a href="#" @click.prevent="sortBy('status')">
                                                STATUS{{ sortIcon('status') }}
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" @click.prevent="sortBy('created_at')">
                                                JOINED{{ sortIcon('created_at') }}
                                            </a>
                                        </th>
                                    </tr>
                                    <tr class="filters">
                                        <td>
                                            <input
                                                v-model="filterUsername"
                                                type="text"
                                                class="form-control form-control-sm"
                                                placeholder="Filter..."
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="filterEmail"
                                                type="text"
                                                class="form-control form-control-sm"
                                                placeholder="Filter..."
                                            />
                                        </td>
                                        <td>
                                            <select v-model="filterStatus" class="form-select form-select-sm">
                                                <option value="">All</option>
                                                <option :value="STATUS_ACTIVE">Active</option>
                                                <option :value="STATUS_INACTIVE">Inactive</option>
                                                <option :value="STATUS_DELETED">Deleted</option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="users.length === 0">
                                        <td colspan="4" class="empty">No results found.</td>
                                    </tr>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{ user.username }}</td>
                                        <td>
                                            <a :href="`mailto:${user.email}`">{{ user.email }}</a>
                                        </td>
                                        <td>
                                            <span :class="['badge', 'rounded-pill', getStatus(user.status).class]">
                                                {{ getStatus(user.status).label }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap">{{ formatDate(user.created_at) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <nav v-if="pagination.pageCount > 1" class="d-flex justify-content-center mt-3">
                                <ul class="pagination pagination-sm mb-0">
                                    <li
                                        class="page-item"
                                        :class="{ disabled: pagination.currentPage === 1 }"
                                    >
                                        <a class="page-link" href="#" @click.prevent="goToPage(pagination.currentPage - 1)">&laquo;</a>
                                    </li>
                                    <li
                                        v-for="p in pages()"
                                        :key="p"
                                        class="page-item"
                                        :class="{ active: p === pagination.currentPage }"
                                    >
                                        <a class="page-link" href="#" @click.prevent="goToPage(p)">{{ p }}</a>
                                    </li>
                                    <li
                                        class="page-item"
                                        :class="{ disabled: pagination.currentPage === pagination.pageCount }"
                                    >
                                        <a class="page-link" href="#" @click.prevent="goToPage(pagination.currentPage + 1)">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>

                            <!-- Summary -->
                            <div v-if="users.length > 0" class="summary">
                                Showing {{ (pagination.currentPage - 1) * pagination.pageSize + 1 }}-{{ Math.min(pagination.currentPage * pagination.pageSize, pagination.totalCount) }} of {{ pagination.totalCount }} {{ pagination.totalCount === 1 ? 'item' : 'items' }}.
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
