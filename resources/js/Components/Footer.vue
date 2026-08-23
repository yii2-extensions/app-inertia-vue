<script setup>
const year = new Date().getFullYear();
</script>

<template>
    <footer class="site-footer">
        <div class="site-footer__inner">
            <div class="site-footer__brand">
                <a
                    href="https://www.yiiframework.com/"
                    rel="noopener noreferrer"
                    target="_blank"
                    aria-label="Yii Framework website"
                >
                    <img
                        src="/images/yii_logo_light.svg"
                        alt=""
                        class="dark:hidden"
                    />
                    <img
                        src="/images/yii_logo_dark.svg"
                        alt=""
                        class="hidden dark:block"
                    />
                </a>
                <p>
                    A working Yii 22 + Inertia + Vue reference for the
                    framework's next development line.
                </p>
            </div>

            <nav class="site-footer__links" aria-label="Project links">
                <a
                    href="https://github.com/yiisoft/yii2/tree/22.0"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    Branch 22.0
                </a>
                <a
                    href="https://github.com/yiisoft/yii2/blob/22.0/framework/UPGRADE-22.md"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    Upgrade guide
                </a>
                <a
                    href="https://github.com/yii2-extensions/app-inertia-vue"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    Application source
                </a>
            </nav>

            <div class="site-footer__status">
                <span><i aria-hidden="true"></i> Development preview</span>
                <small>&copy; {{ year }} Terabytesoftw · BSD-3-Clause</small>
            </div>
        </div>
    </footer>
</template>
