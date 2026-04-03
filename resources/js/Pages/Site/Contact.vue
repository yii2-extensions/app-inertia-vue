<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3'

const page = usePage()

const form = useForm({
    'ContactForm[name]': '',
    'ContactForm[email]': '',
    'ContactForm[phone]': '',
    'ContactForm[subject]': '',
    'ContactForm[body]': '',
})

const submit = () => {
    form.post('/site/contact', {
        preserveScroll: true,
    })
}

const maskPhone = (event) => {
    let value = event.target.value.replace(/\D/g, '')

    if (value.length > 10) {
        value = value.slice(0, 10)
    }

    if (value.length >= 7) {
        value = `(${value.slice(0, 3)}) ${value.slice(3, 6)}-${value.slice(6)}`
    } else if (value.length >= 4) {
        value = `(${value.slice(0, 3)}) ${value.slice(3)}`
    } else if (value.length >= 1) {
        value = `(${value}`
    }

    form['ContactForm[phone]'] = value
}

const fieldError = (field) => {
    const errors = page.props.errors
    return errors?.[field]?.[0] || null
}
</script>

<template>
    <Head title="Contact us" />

    <!-- Success state -->
    <div v-if="page.props.flash?.success" class="site-contact-success d-flex align-items-center justify-content-center text-center">
        <div class="site-contact-success-content mx-auto">
            <h1 class="display-6 fw-semibold mb-3">Message sent</h1>
            <Link href="/site/contact" class="btn btn-outline-primary btn-lg">Send another message</Link>
        </div>
    </div>

    <!-- Contact form -->
    <div v-else class="site-contact d-flex align-items-center justify-content-center py-2">
        <div class="card border-0 overflow-hidden login-split-card login-split-card-wide">
            <div class="row g-0">

                <!-- Brand panel -->
                <div class="col-md-4 d-none d-md-flex login-brand-panel text-white">
                    <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                        <div>
                            <img src="/images/yii3_full_white_for_dark.svg" alt="Yii Framework" class="mb-4" height="40" />
                        </div>
                        <div>
                            <h2 class="fw-bold mb-3 login-brand-title">Get In<br />Touch</h2>
                            <p class="opacity-75 mb-0 login-brand-text">
                                Have a question or business inquiry? We would love to hear from you.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form panel -->
                <div class="col-md-8">
                    <div class="p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <h1 class="h3 fw-bold mb-1">Contact us</h1>
                            <p class="text-body-secondary small">Fill out the form below and we will get back to you</p>
                        </div>

                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <label class="form-label fw-semibold small">Your Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text" aria-hidden="true">&#128100;</span>
                                        <input
                                            v-model="form['ContactForm[name]']"
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': fieldError('name') }"
                                            placeholder="Name"
                                            autofocus
                                        />
                                    </div>
                                    <div v-if="fieldError('name')" class="invalid-feedback d-block">{{ fieldError('name') }}</div>
                                </div>

                                <div class="col-sm-6 mb-2">
                                    <label class="form-label fw-semibold small">Your Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text" aria-hidden="true">&#9993;</span>
                                        <input
                                            v-model="form['ContactForm[email]']"
                                            type="email"
                                            class="form-control"
                                            :class="{ 'is-invalid': fieldError('email') }"
                                            placeholder="email@example.com"
                                        />
                                    </div>
                                    <div v-if="fieldError('email')" class="invalid-feedback d-block">{{ fieldError('email') }}</div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold small">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">&#128222;</span>
                                    <input
                                        :value="form['ContactForm[phone]']"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': fieldError('phone') }"
                                        placeholder="(999) 999-9999"
                                        @input="maskPhone"
                                    />
                                </div>
                                <div v-if="fieldError('phone')" class="invalid-feedback d-block">{{ fieldError('phone') }}</div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold small">Subject</label>
                                <div class="input-group">
                                    <span class="input-group-text" aria-hidden="true">&#128172;</span>
                                    <input
                                        v-model="form['ContactForm[subject]']"
                                        type="text"
                                        class="form-control"
                                        :class="{ 'is-invalid': fieldError('subject') }"
                                        placeholder="Subject"
                                    />
                                </div>
                                <div v-if="fieldError('subject')" class="invalid-feedback d-block">{{ fieldError('subject') }}</div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold small">Message</label>
                                <textarea
                                    v-model="form['ContactForm[body]']"
                                    class="form-control"
                                    :class="{ 'is-invalid': fieldError('body') }"
                                    placeholder="Your message..."
                                ></textarea>
                                <div v-if="fieldError('body')" class="invalid-feedback d-block">{{ fieldError('body') }}</div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button
                                    type="submit"
                                    class="btn login-btn text-white px-3"
                                    :disabled="form.processing"
                                >Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
