<script setup>
import { ref } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import ThemeToggle from './ThemeToggle.vue'

const page = usePage()
const collapsed = ref(true)

const toggle = () => {
    collapsed.value = !collapsed.value
}

const logout = () => {
    router.post('/user/logout')
}
</script>

<template>
    <header id="header">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <div class="container">
                <Link class="navbar-brand" href="/">{{ page.props.appName }}</Link>

                <button
                    class="navbar-toggler"
                    type="button"
                    :aria-expanded="!collapsed"
                    aria-label="Toggle navigation"
                    @click="toggle"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" :class="{ show: !collapsed }">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <Link class="nav-link" href="/">Home</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" href="/site/about">About</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" href="/site/contact">Contact</Link>
                        </li>
                        <li v-if="page.props.auth.canViewUsers" class="nav-item">
                            <Link class="nav-link" href="/user/index">Users</Link>
                        </li>
                        <li v-if="page.props.auth.isGuest" class="nav-item">
                            <Link class="nav-link" href="/user/signup">Signup</Link>
                        </li>
                        <li v-if="page.props.auth.isGuest" class="nav-item">
                            <Link class="nav-link" href="/user/login">Login</Link>
                        </li>
                        <li v-if="!page.props.auth.isGuest" class="nav-item">
                            <a href="#" class="nav-link logout" @click.prevent="logout">
                                Logout ({{ page.props.auth.user?.username }})
                            </a>
                        </li>
                    </ul>

                    <ThemeToggle />
                </div>
            </div>
        </nav>
    </header>
</template>
