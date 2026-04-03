<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3'

const page = usePage()

const form = useForm({
    'LoginForm[username]': '',
    'LoginForm[password]': '',
    'LoginForm[rememberMe]': true,
})

const submit = () => {
    form.post('/user/login', {
        preserveScroll: true,
    })
}

const fieldError = (field) => {
    const errors = page.props.errors
    return errors?.[field]?.[0] || null
}
</script>

<template>
    <Head title="Login to your account" />

    <div class="site-login d-flex align-items-center justify-content-center py-5">
        <div class="card border-0 overflow-hidden login-split-card">
            <div class="row g-0">

                <!-- Brand panel -->
                <div class="col-md-5 d-none d-md-flex login-brand-panel text-white">
                    <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                        <div>
                            <img src="/images/yii3_full_white_for_dark.svg" alt="Yii Framework" class="mb-4" height="40" />
                        </div>
                        <div>
                            <h2 class="fw-bold mb-3 login-brand-title">Welcome<br />Back</h2>
                            <p class="opacity-75 mb-0 login-brand-text">
                                Log in to access your Yii2 application and manage your account.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form panel -->
                <div class="col-md-7">
                    <div class="p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <h1 class="h3 fw-bold mb-1">Login to your account</h1>
                            <p class="text-body-secondary small">Enter your credentials to continue</p>
                        </div>

                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Your Username</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">&#128100;</span>
                                    <input
                                        v-model="form['LoginForm[username]']"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': fieldError('username') }"
                                        placeholder="admin"
                                        autofocus
                                    />
                                </div>
                                <div v-if="fieldError('username')" class="invalid-feedback d-block">{{ fieldError('username') }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Your Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">&#128274;</span>
                                    <input
                                        v-model="form['LoginForm[password]']"
                                        type="password"
                                        class="form-control"
                                        :class="{ 'is-invalid': fieldError('password') }"
                                        placeholder="admin"
                                    />
                                </div>
                                <div v-if="fieldError('password')" class="invalid-feedback d-block">{{ fieldError('password') }}</div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input
                                        v-model="form['LoginForm[rememberMe]']"
                                        type="checkbox"
                                        class="form-check-input"
                                        id="remember-me"
                                    />
                                    <label class="form-check-label" for="remember-me">Remember Me</label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button
                                    type="submit"
                                    class="btn login-btn btn-lg rounded-3 text-white"
                                    :disabled="form.processing"
                                >Login</button>
                            </div>
                        </form>

                        <div class="login-footer-links mt-4">
                            <div class="login-footer-divider"><span>or</span></div>
                            <div class="text-center mt-3">
                                <p class="mb-2 small">
                                    Don't have an account?
                                    <a href="/user/signup" class="fw-semibold login-footer-action">Sign up</a>
                                </p>
                                <div class="d-flex justify-content-center gap-3 small">
                                    <a href="/user/request-password-reset" class="login-footer-action">Forgot password</a>
                                    <span class="text-body-tertiary">|</span>
                                    <a href="/user/resend-verification-email" class="login-footer-action">Resend verification</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
