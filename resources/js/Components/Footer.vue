<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const year = new Date().getFullYear()
</script>

<template>
    <footer id="footer" class="mt-auto py-3 bg-body-tertiary">
        <div class="container">
            <div class="row text-body-secondary">
                <div class="col-md-6 text-center text-md-start">
                    &copy; {{ page.props.appName }} {{ year }}
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a
                        href="https://www.yiiframework.com/"
                        rel="external"
                        aria-label="Powered by Yii Framework"
                        class="text-body-secondary text-decoration-none"
                    >
                        Powered by
                        <img
                            src="/images/yii3_full_for_light.svg"
                            alt=""
                            aria-hidden="true"
                            class="align-text-bottom footer-logo-light"
                            height="28"
                        />
                        <img
                            src="/images/yii3_full_for_dark.svg"
                            alt=""
                            aria-hidden="true"
                            class="align-text-bottom footer-logo-dark"
                            height="28"
                        />
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>
