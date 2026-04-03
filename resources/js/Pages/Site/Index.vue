<script setup>
import { Head } from '@inertiajs/vue3'

const extensions = [
    {
        icon: '\u{1F50E}',
        name: 'yii2-debug',
        description: 'Debug toolbar and debugger for Yii2. Inspect logs, database queries, request data, and application performance in real time.',
        url: 'https://www.yiiframework.com/extension/yiisoft/yii2-debug',
    },
    {
        icon: '\u2699',
        name: 'yii2-gii',
        description: 'Automatic code generator for models, controllers, CRUD, forms, and modules. Boost your productivity with scaffolding.',
        url: 'https://www.yiiframework.com/extension/yiisoft/yii2-gii',
    },
    {
        icon: '\u{1F4CB}',
        name: 'yii2-queue',
        description: 'Asynchronous job queue with support for DB, Redis, AMQP, Beanstalk, and SQS drivers. Run background tasks with ease.',
        url: 'https://www.yiiframework.com/extension/yiisoft/yii2-queue',
    },
    {
        icon: '\u26A1',
        name: 'yii2-redis',
        description: 'Redis integration providing cache, session, and ActiveRecord support. Leverage in-memory storage for blazing-fast data access.',
        url: 'https://www.yiiframework.com/extension/yiisoft/yii2-redis',
    },
    {
        icon: '\u{1F50D}',
        name: 'yii2-elasticsearch',
        description: 'Elasticsearch integration with ActiveRecord and query builder. Add powerful full-text search capabilities to your application.',
        url: 'https://www.yiiframework.com/extension/yiisoft/yii2-elasticsearch',
    },
    {
        icon: '\u2709',
        name: 'yii2-symfonymailer',
        description: 'Email sending integration powered by Symfony Mailer. Compose and deliver rich HTML emails with attachments and templates.',
        url: 'https://github.com/yiisoft/yii2-symfonymailer',
    },
]
</script>

<template>
    <Head title="My Yii Application" />

    <div class="site-index">
        <!-- Hero banner with Yii gradient -->
        <div class="hero-banner text-white rounded-4 p-5 mb-4 position-relative overflow-hidden">
            <img
                src="/images/yii3_full_white_for_dark.svg"
                alt=""
                class="d-none d-lg-block position-absolute hero-logo"
            />
            <div class="position-relative">
                <h1 class="display-5 fw-bold mb-3">Build with Yii Framework</h1>
                <p class="lead opacity-75 mb-4 hero-lead">
                    A high-performance PHP framework best for developing web applications.
                    Fast, secure, and professional.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <a
                        href="https://www.yiiframework.com/doc/guide/2.0/en/start-installation"
                        class="btn btn-light btn-lg fw-semibold px-4"
                        rel="noopener noreferrer"
                        target="_blank"
                    >Get Started</a>
                    <a
                        href="https://www.yiiframework.com/doc/api/2.0"
                        class="btn btn-outline-light btn-lg px-4"
                        rel="noopener noreferrer"
                        target="_blank"
                    >API Reference</a>
                </div>
            </div>
        </div>

        <!-- Extensions grid -->
        <div class="row g-3">
            <div v-for="ext in extensions" :key="ext.name" class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-3 extension-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="extension-icon" aria-hidden="true">{{ ext.icon }}</span>
                            <h3 class="h6 fw-bold mb-0 ms-2">{{ ext.name }}</h3>
                        </div>
                        <p class="text-body-secondary small mb-0">{{ ext.description }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <a
                            :href="ext.url"
                            :aria-label="`Learn more about ${ext.name}`"
                            class="btn btn-sm btn-outline-secondary"
                            rel="noopener noreferrer"
                            target="_blank"
                        >Learn more &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
