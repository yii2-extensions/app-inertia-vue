<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3'

const page = usePage()

const form = useForm({
    'ResendVerificationEmailForm[email]': '',
})

const submit = () => {
    form.post('/user/resend-verification-email', {
        preserveScroll: true,
    })
}

const fieldError = (field) => {
    const errors = page.props.errors
    return errors?.[field]?.[0] || null
}
</script>

<template>
    <Head title="Resend verification email" />

    <div class="site-resend-verification-email d-flex align-items-center justify-content-center py-5">
        <div class="card border-0 overflow-hidden login-split-card">
            <div class="row g-0">

                <!-- Brand panel -->
                <div class="col-md-5 d-none d-md-flex login-brand-panel text-white">
                    <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                        <div>
                            <img src="/images/yii3_full_white_for_dark.svg" alt="Yii Framework" class="mb-4" height="40" />
                        </div>
                        <div>
                            <h2 class="fw-bold mb-3 login-brand-title">Verify Your<br />Email</h2>
                            <p class="opacity-75 mb-0 login-brand-text">
                                We will send a new verification email to confirm your account.
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
                            <h1 class="h3 fw-bold mb-1">Resend verification email</h1>
                            <p class="text-body-secondary small">Enter your email to receive a new verification link</p>
                        </div>

                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Your Email</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">&#9993;</span>
                                    <input
                                        v-model="form['ResendVerificationEmailForm[email]']"
                                        type="email"
                                        class="form-control"
                                        :class="{ 'is-invalid': fieldError('email') }"
                                        placeholder="email@example.com"
                                        autofocus
                                    />
                                </div>
                                <div v-if="fieldError('email')" class="invalid-feedback d-block">{{ fieldError('email') }}</div>
                            </div>

                            <div class="d-grid">
                                <button
                                    type="submit"
                                    class="btn login-btn btn-lg rounded-3 text-white"
                                    :disabled="form.processing"
                                >Send</button>
                            </div>
                        </form>

                        <div class="text-body-secondary text-center mt-3 small">
                            Already verified? <a href="/user/login">Login</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
