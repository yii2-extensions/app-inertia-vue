<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3'

const props = defineProps({
    token: {
        type: String,
        required: true,
    },
})

const page = usePage()

const form = useForm({
    'ResetPasswordForm[password]': '',
})

const submit = () => {
    form.post(`/user/reset-password?token=${props.token}`, {
        preserveScroll: true,
    })
}

const fieldError = (field) => {
    const errors = page.props.errors
    return errors?.[field]?.[0] || null
}
</script>

<template>
    <Head title="Set your new password" />

    <div class="site-reset-password d-flex align-items-center justify-content-center py-5">
        <div class="card border-0 overflow-hidden login-split-card">
            <div class="row g-0">

                <!-- Brand panel -->
                <div class="col-md-5 d-none d-md-flex login-brand-panel text-white">
                    <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                        <div>
                            <img src="/images/yii3_full_white_for_dark.svg" alt="Yii Framework" class="mb-4" height="40" />
                        </div>
                        <div>
                            <h2 class="fw-bold mb-3 login-brand-title">New<br />Password</h2>
                            <p class="opacity-75 mb-0 login-brand-text">
                                Choose a strong password to keep your account secure.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form panel -->
                <div class="col-md-7">
                    <div class="p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <div class="d-md-none mb-3">
                                <img src="/images/yii3_full_black_for_light.svg" alt="Yii Framework" class="login-mobile-logo" height="36" />
                            </div>
                            <h1 class="h3 fw-bold mb-1">Set your new password</h1>
                            <p class="text-body-secondary small">Please choose a new password for your account</p>
                        </div>

                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">&#128274;</span>
                                    <input
                                        v-model="form['ResetPasswordForm[password]']"
                                        type="password"
                                        class="form-control"
                                        :class="{ 'is-invalid': fieldError('password') }"
                                        placeholder="Password"
                                        autofocus
                                    />
                                </div>
                                <div v-if="fieldError('password')" class="invalid-feedback d-block">{{ fieldError('password') }}</div>
                            </div>

                            <div class="d-grid">
                                <button
                                    type="submit"
                                    class="btn login-btn btn-lg rounded-3 text-white"
                                    :disabled="form.processing"
                                >Save</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
