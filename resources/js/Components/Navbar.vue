<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { useTheme } from "../composables/useTheme.js";
import ThemeToggle from "./ThemeToggle.vue";

const page = usePage();
const open = ref(false);
const { theme, toggleTheme } = useTheme();

const landingLinks = [
    { href: "/#new-in-22", label: "What’s new" },
    { href: "/#stack", label: "Stack" },
    { href: "/#demo", label: "Explore" },
];

const isActive = (href) => {
    const current = page.url;

    return (
        current === href ||
        current.startsWith(href + "?") ||
        current.startsWith(href + "/")
    );
};

const closeMenu = () => {
    open.value = false;
};
</script>

<template>
    <header class="site-header">
        <nav
            class="site-nav"
            aria-label="Primary navigation"
            @keydown.esc="closeMenu"
        >
            <div class="site-nav__inner">
                <Link
                    href="/"
                    class="site-brand"
                    aria-label="Yii Framework 22.0 preview home"
                    @click="closeMenu"
                >
                    <img
                        src="/images/yii_logo_light.svg"
                        alt=""
                        class="site-brand__logo dark:hidden"
                    />
                    <img
                        src="/images/yii_logo_dark.svg"
                        alt=""
                        class="site-brand__logo hidden dark:block"
                    />
                    <span>22.0 preview</span>
                </Link>

                <div class="site-nav__desktop">
                    <Link
                        v-for="item in landingLinks"
                        :key="item.href"
                        :href="item.href"
                        class="site-nav__link"
                    >
                        {{ item.label }}
                    </Link>
                    <a
                        href="https://github.com/yiisoft/yii2/blob/22.0/framework/UPGRADE-22.md"
                        class="site-nav__link"
                        rel="noopener noreferrer"
                        target="_blank"
                    >
                        Upgrade guide
                    </a>

                    <ThemeToggle :theme="theme" @toggle="toggleTheme" />

                    <Link
                        v-if="page.props.auth.isGuest"
                        href="/user/login"
                        prefetch
                        :class="[
                            'site-nav__account',
                            {
                                'site-nav__account--active':
                                    isActive('/user/login'),
                            },
                        ]"
                    >
                        Sign in
                    </Link>
                    <Link
                        v-if="page.props.auth.isGuest"
                        href="/user/signup"
                        prefetch
                        class="site-nav__primary"
                    >
                        Run the app
                    </Link>

                    <Link
                        v-if="page.props.auth.canViewUsers"
                        href="/user/index"
                        prefetch
                        class="site-nav__account"
                    >
                        {{ page.props.auth.user?.username }}
                    </Link>
                    <Link
                        v-if="!page.props.auth.isGuest"
                        href="/user/logout"
                        method="post"
                        as="button"
                        class="site-nav__primary"
                    >
                        Sign out
                    </Link>
                </div>

                <div class="site-nav__mobile-actions">
                    <ThemeToggle :theme="theme" @toggle="toggleTheme" />
                    <button
                        type="button"
                        class="site-nav__menu-button"
                        :aria-expanded="open"
                        aria-controls="mobile-navigation"
                        :aria-label="
                            open ? 'Close navigation' : 'Open navigation'
                        "
                        @click="open = !open"
                    >
                        <span
                            class="site-nav__menu-icon"
                            :class="{ 'site-nav__menu-icon--open': open }"
                            aria-hidden="true"
                        >
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
            </div>

            <div v-show="open" id="mobile-navigation" class="site-nav__mobile">
                <Link
                    v-for="item in landingLinks"
                    :key="item.href"
                    :href="item.href"
                    @click="closeMenu"
                >
                    {{ item.label }}
                </Link>
                <a
                    href="https://github.com/yiisoft/yii2/blob/22.0/framework/UPGRADE-22.md"
                    rel="noopener noreferrer"
                    target="_blank"
                    @click="closeMenu"
                >
                    Upgrade guide
                </a>
                <Link
                    v-if="page.props.auth.isGuest"
                    href="/user/login"
                    prefetch
                    @click="closeMenu"
                >
                    Sign in
                </Link>
                <Link
                    v-if="page.props.auth.isGuest"
                    href="/user/signup"
                    prefetch
                    class="site-nav__mobile-primary"
                    @click="closeMenu"
                >
                    Run the app
                </Link>
                <Link
                    v-if="page.props.auth.canViewUsers"
                    href="/user/index"
                    prefetch
                    @click="closeMenu"
                >
                    User console
                </Link>
                <Link
                    v-if="!page.props.auth.isGuest"
                    href="/user/logout"
                    method="post"
                    as="button"
                    class="site-nav__mobile-logout"
                    @click="closeMenu"
                >
                    Sign out
                </Link>
            </div>
        </nav>
    </header>
</template>
