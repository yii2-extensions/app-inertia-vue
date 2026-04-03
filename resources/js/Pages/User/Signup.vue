<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3'

const page = usePage()

const form = useForm({
    'SignupForm[username]': '',
    'SignupForm[email]': '',
    'SignupForm[password]': '',
})

const submit = () => {
    form.post('/user/signup', {
        preserveScroll: true,
    })
}

const fieldError = (field) => {
    const errors = page.props.errors
    return errors?.[field]?.[0] || null
}
</script>

<template>
    <Head title="Create a new account" />

    <div class="site-signup d-flex align-items-center justify-content-center py-5">
        <div class="card border-0 overflow-hidden login-split-card">
            <div class="row g-0">

                <!-- Brand panel -->
                <div class="col-md-5 d-none d-md-flex login-brand-panel text-white">
                    <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                        <div>
                            <img src="/images/yii3_full_white_for_dark.svg" alt="Yii Framework" class="mb-4" height="40" />
                        </div>
                        <div>
                            <h2 class="fw-bold mb-3 login-brand-title">Create Your<br />Account</h2>
                            <p class="opacity-75 mb-0 login-brand-text">
                                Join us and start building amazing applications with Yii2.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form panel -->
                <div class="col-md-7">
                    <div class="p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <h1 class="h3 fw-bold mb-1">Create a new account</h1>
                            <p class="text-body-secondary small">Fill out the fields below to get started</p>
                        </div>

                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Your Username</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">&#128100;</span>
                                    <input
                                        v-model="form['SignupForm[username]']"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': fieldError('username') }"
                                        placeholder="username"
                                        autofocus
                                    />
                                </div>
                                <div v-if="fieldError('username')" class="invalid-feedback d-block">{{ fieldError('username') }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Your Email</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">&#9993;</span>
                                    <input
                                        v-model="form['SignupForm[email]']"
                                        type="email"
                                        class="form-control"
                                        :class="{ 'is-invalid': fieldError('email') }"
                                        placeholder="email@example.com"
                                    />
                                </div>
                                <div v-if="fieldError('email')" class="invalid-feedback d-block">{{ fieldError('email') }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Your Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">&#128274;</span>
                                    <input
                                        v-model="form['SignupForm[password]']"
                                        type="password"
                                        class="form-control"
                                        :class="{ 'is-invalid': fieldError('password') }"
                                        placeholder="Password"
                                    />
                                </div>
                                <div v-if="fieldError('password')" class="invalid-feedback d-block">{{ fieldError('password') }}</div>
                            </div>

                            <div class="d-grid">
                                <button
                                    type="submit"
                                    class="btn login-btn btn-lg rounded-3 text-white"
                                    :disabled="form.processing"
                                >Signup</button>
                            </div>
                        </form>

                        <div class="login-footer-links mt-4">
                            <div class="login-footer-divider"><span>or</span></div>
                            <p class="text-center mt-3 mb-0 small">
                                Already have an account?
                                <a href="/user/login" class="fw-semibold login-footer-action">Login</a>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
