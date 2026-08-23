<script setup>
import { computed, ref } from "vue";
import { Head, InfiniteScroll, Link, router, usePage } from "@inertiajs/vue3";

const props = defineProps({
    protocolFeed: {
        type: Object,
        required: true,
    },
    runtime: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const refreshing = ref(false);

const accountDemo = computed(() => {
    if (page.props.auth.isGuest) {
        return {
            href: "/user/signup",
            label: "Create an account",
        };
    }

    if (page.props.auth.canViewUsers) {
        return {
            href: "/user/index",
            label: "Open user console",
        };
    }

    return {
        href: "/site/about",
        label: "Read the project overview",
    };
});

const releaseProofs = [
    {
        id: "standalone-actions",
        index: "01",
        area: "Standalone HTTP actions",
        title: "One route. One focused class.",
        description:
            "Place a class in the controller namespace and Yii discovers the route, binds the request, and resolves typed run() dependencies without a hosting controller.",
        signal: "NEW ROUTE PRIMITIVE",
        accent: "orange",
        href: "https://github.com/yiisoft/yii2/blob/22.0/docs/guide/tutorial-standalone-actions.md",
        file: "app/controllers/HealthAction.php",
        request: "GET /health",
        code: [
            { text: "final class HealthAction extends Action", emphasis: true },
            { text: "{" },
            {
                text: "    public function run(Connection $db): string",
                emphasis: true,
            },
            { text: "    {" },
            {
                text: "        return $db->createCommand('SELECT 1')->queryScalar()",
            },
            { text: "            ? 'ready' : 'down';" },
            { text: "    }" },
            { text: "}" },
        ],
        note: "22.0 resolves the $db component by name and type before run() executes.",
        facts: [
            { label: "Discovery", value: "Convention" },
            { label: "Dependencies", value: "Auto-wired" },
        ],
    },
    {
        id: "union-query",
        index: "02",
        area: "Compound query controls",
        title: "Sort the UNION, not its first SELECT.",
        description:
            "Yii 2.0/master can compose a UNION. Branch 22.0 adds explicit ordering and pagination for the complete compound result through one portable query API.",
        signal: "22.0-ONLY GLOBAL API",
        accent: "green",
        href: "https://github.com/yiisoft/yii2/blob/22.0/framework/UPGRADE-22.md",
        file: "OrderFeed.php",
        request: "COMPOUND RESULT",
        code: [
            { text: "$query = (new Query())" },
            { text: "    ->from('orders')" },
            {
                text: "    ->union((new Query())->from('archived_orders'), true)",
            },
            {
                text: "    ->unionOrderBy(['created_at' => SORT_DESC])",
                emphasis: true,
            },
            { text: "    ->unionLimit(20)", emphasis: true },
            { text: "    ->unionOffset(40);", emphasis: true },
        ],
        note: "The highlighted modifiers are not available on the 2.0/master line.",
        facts: [
            { label: "Scope", value: "Whole UNION" },
            { label: "Controls", value: "Order + page" },
        ],
    },
];

const foundationChanges = [
    {
        area: "Front end",
        title: "Legacy assumptions are optional.",
        description:
            "NPM-first assets, opt-in jQuery, native DOM events, and Bootstrap-agnostic widget defaults.",
        signal: "NPM / DOM / CSS",
        accent: "blue",
    },
    {
        area: "Runtime",
        title: "A modern PHP baseline.",
        description:
            "PHP 8.3+ and Composer-only autoloading remove compatibility paths from new applications.",
        signal: "PHP 8.3+",
        accent: "green",
    },
    {
        area: "Safety + logs",
        title: "Interoperable where it matters.",
        description:
            "Sensitive parameters are redacted while bidirectional PSR-3 adapters connect Yii and external loggers.",
        signal: "SENSITIVE / PSR-3",
        accent: "orange",
    },
];

const stack = [
    {
        name: "PHP 8.3+",
        role: "Runtime",
        detail: "A typed, current foundation for the server-side application.",
    },
    {
        name: "Yii 22.0",
        role: "Application",
        detail: "Routing, validation, persistence, security, and dependency injection.",
    },
    {
        name: "Inertia 3",
        role: "Protocol",
        detail: "Server-driven pages without building and maintaining a separate API.",
    },
    {
        name: "Vue 3 + Vite 8",
        role: "Interface",
        detail: "Reactive views, instant feedback, and a modern asset pipeline.",
    },
];

const demos = computed(() => [
    {
        eyebrow: "Identity",
        title: "Account flow",
        description:
            "Follow server-side validation through signup, verification, login, and password recovery.",
        href: accountDemo.value.href,
        label: accountDemo.value.label,
        inertia: true,
    },
    {
        eyebrow: "Diagnostics",
        title: "Yii debug panel",
        description:
            "Inspect requests, queries, logs, configuration, and timings with the integrated development module.",
        href: "/debug",
        label: "Inspect the runtime",
        inertia: false,
    },
    {
        eyebrow: "Source",
        title: "Start from the template",
        description:
            "Explore the complete Yii2, Inertia, Vue, and Vite application structure on GitHub.",
        href: "https://github.com/yii2-extensions/app-inertia-vue",
        label: "View source code",
        inertia: false,
        external: true,
    },
]);

const replayRequest = () => {
    router.reload({
        only: ["runtime"],
        onStart: () => {
            refreshing.value = true;
        },
        onFinish: () => {
            refreshing.value = false;
        },
    });
};
</script>

<template>
    <Head>
        <title>Yii 22.0 Preview — Modern PHP, familiar Yii</title>
        <meta
            head-key="description"
            name="description"
            content="Explore the Yii 22.0 development line with PHP 8.3, Inertia 3, Vue 3, and Vite 8."
        />
    </Head>

    <div class="landing-page">
        <section class="release-hero" aria-labelledby="release-heading">
            <div class="release-hero__copy">
                <div class="release-kicker">
                    <span
                        class="release-kicker__mark"
                        aria-hidden="true"
                    ></span>
                    Yii Framework / 22.0 preview
                </div>

                <h1 id="release-heading" class="release-title">
                    The Yii you know.
                    <span>Ready for what ships next.</span>
                </h1>

                <p class="release-lede">
                    A leaner Yii2 core for modern PHP, paired with Inertia, Vue
                    3, and Vite. Keep the server-side architecture you trust and
                    move through the interface at application speed.
                </p>

                <div class="release-actions">
                    <a
                        class="release-button release-button--primary"
                        href="#new-in-22"
                    >
                        Explore 22.0
                    </a>
                    <Link
                        class="release-button release-button--quiet"
                        :href="accountDemo.href"
                        prefetch
                    >
                        Run the application
                    </Link>
                </div>

                <p class="release-note">
                    22.0 is under active development and intended for
                    evaluation.
                </p>
            </div>

            <div class="runtime-window" aria-label="Application request flow">
                <div class="runtime-window__bar">
                    <div class="runtime-window__status">
                        <span aria-hidden="true"></span>
                        Runtime connected
                    </div>
                    <span>localhost:8080</span>
                </div>

                <div class="runtime-window__body">
                    <div class="runtime-request">
                        <span>GET</span>
                        <strong>/</strong>
                        <small>Inertia response</small>
                    </div>

                    <div class="runtime-path" aria-hidden="true">
                        <span
                            class="runtime-path__line runtime-path__line--blue"
                        ></span>
                        <span
                            class="runtime-path__line runtime-path__line--green"
                        ></span>
                        <span
                            class="runtime-path__line runtime-path__line--orange"
                        ></span>
                    </div>

                    <ol class="runtime-stack">
                        <li>
                            <span>01</span>
                            <strong>PHP 8.3+</strong>
                            <small>request</small>
                        </li>
                        <li>
                            <span>02</span>
                            <strong>Yii 22</strong>
                            <small>response</small>
                        </li>
                        <li>
                            <span>03</span>
                            <strong>Inertia 3</strong>
                            <small>protocol</small>
                        </li>
                        <li>
                            <span>04</span>
                            <strong>Vue 3</strong>
                            <small>interface</small>
                        </li>
                    </ol>

                    <div class="runtime-window__footer">
                        <code>return $this-&gt;inertia('Site/Index');</code>
                        <span>Vite HMR ready</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="release-spec" aria-label="Technology versions">
            <div>
                <span>Framework</span>
                <strong>{{ props.runtime.framework }}</strong>
            </div>
            <div>
                <span>Runtime</span>
                <strong>PHP {{ props.runtime.php }}</strong>
            </div>
            <div>
                <span>Navigation</span>
                <strong>Inertia 3</strong>
            </div>
            <div>
                <span>Interface</span>
                <strong>Vue 3</strong>
            </div>
            <div>
                <span>Tooling</span>
                <strong>Vite 8</strong>
            </div>
        </div>

        <section
            id="new-in-22"
            class="landing-section change-section"
            aria-labelledby="changes-heading"
        >
            <div class="section-intro">
                <div>
                    <span class="section-label">What’s new in 22.0</span>
                    <h2 id="changes-heading">
                        The branch makes its case in code.
                    </h2>
                </div>
                <p>
                    Two framework-level APIs show the direction clearly: smaller
                    HTTP units, stronger dependency injection, and query
                    controls that operate where developers expect them to.
                </p>
            </div>

            <div id="release-dossier" class="release-dossier">
                <header class="release-dossier__masthead">
                    <div class="release-dossier__branch">
                        <span aria-hidden="true"></span>
                        <strong>22.0 change register</strong>
                    </div>
                    <code>2 framework proofs · 3 foundation shifts</code>
                    <a
                        href="https://github.com/yiisoft/yii2/blob/22.0/framework/UPGRADE-22.md"
                        rel="noopener noreferrer"
                        target="_blank"
                    >
                        Full upgrade guide
                        <span aria-hidden="true">↗</span>
                    </a>
                </header>

                <div class="release-dossier__proofs">
                    <article
                        v-for="proof in releaseProofs"
                        :id="proof.id"
                        :key="proof.id"
                        class="release-proof"
                        :data-accent="proof.accent"
                    >
                        <div class="release-proof__index" aria-hidden="true">
                            {{ proof.index }}
                        </div>

                        <div class="release-proof__copy">
                            <div class="release-proof__meta">
                                <span>{{ proof.area }}</span>
                                <code>{{ proof.signal }}</code>
                            </div>
                            <h3>{{ proof.title }}</h3>
                            <p>{{ proof.description }}</p>

                            <dl class="release-proof__facts">
                                <div
                                    v-for="fact in proof.facts"
                                    :key="fact.label"
                                >
                                    <dt>{{ fact.label }}</dt>
                                    <dd>{{ fact.value }}</dd>
                                </div>
                            </dl>

                            <a
                                class="release-proof__reference"
                                :href="proof.href"
                                rel="noopener noreferrer"
                                target="_blank"
                            >
                                Read the upstream reference
                                <span aria-hidden="true">↗</span>
                            </a>
                        </div>

                        <figure class="release-code">
                            <figcaption>
                                <span>{{ proof.file }}</span>
                                <code>{{ proof.request }}</code>
                            </figcaption>
                            <pre
                                :aria-label="`${proof.area} code example`"
                            ><code><span
                                v-for="(line, lineIndex) in proof.code"
                                :key="`${proof.id}-${lineIndex}`"
                                class="release-code__line"
                                :class="{
                                    'release-code__line--emphasis': line.emphasis,
                                }"
                                :data-line="String(lineIndex + 1).padStart(2, '0')"
                            >{{ line.text }}</span></code></pre>
                            <p>{{ proof.note }}</p>
                        </figure>
                    </article>
                </div>

                <div class="release-foundation">
                    <div class="release-foundation__intro">
                        <span>Foundation shift</span>
                        <strong>Modern defaults below the API.</strong>
                    </div>

                    <article
                        v-for="change in foundationChanges"
                        :key="change.area"
                        :data-accent="change.accent"
                    >
                        <div class="release-foundation__meta">
                            <span>{{ change.area }}</span>
                            <code>{{ change.signal }}</code>
                        </div>
                        <h3>{{ change.title }}</h3>
                        <p>{{ change.description }}</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="stack" class="landing-section stack-section">
            <div class="section-intro section-intro--stack">
                <div>
                    <span class="section-label"
                        >One request, one application</span
                    >
                    <h2>Server-driven.<br />Interface-forward.</h2>
                </div>
                <p>
                    Yii still owns routing, controllers, data, and validation.
                    Inertia turns the response into a page contract, while Vue
                    handles the part your users touch.
                </p>
            </div>

            <div class="stack-workbench">
                <ol class="stack-rail">
                    <li v-for="(layer, index) in stack" :key="layer.name">
                        <div class="stack-rail__index">0{{ index + 1 }}</div>
                        <div class="stack-rail__copy">
                            <span>{{ layer.role }}</span>
                            <strong>{{ layer.name }}</strong>
                            <p>{{ layer.detail }}</p>
                        </div>
                    </li>
                </ol>

                <div class="request-proof">
                    <div class="request-proof__header">
                        <div>
                            <span class="request-proof__eyebrow"
                                >Live partial reload</span
                            >
                            <h3>Replay the server request.</h3>
                        </div>
                        <button
                            type="button"
                            :disabled="refreshing"
                            :aria-busy="refreshing"
                            @click="replayRequest"
                        >
                            {{ refreshing ? "Requesting…" : "Replay request" }}
                        </button>
                    </div>

                    <div class="request-proof__readout" aria-live="polite">
                        <div>
                            <span>Request ID</span>
                            <code>{{ props.runtime.requestId }}</code>
                        </div>
                        <div>
                            <span>Served at</span>
                            <code>{{ props.runtime.servedAt }}</code>
                        </div>
                        <div>
                            <span>Payload</span>
                            <code>runtime only</code>
                        </div>
                    </div>

                    <pre
                        class="request-proof__code"
                    ><code><span class="code-muted">// SiteController.php</span>
<span class="code-blue">return</span> <span class="code-white">$this</span>-&gt;inertia(
    <span class="code-green">'Site/Index'</span>,
    [<span class="code-green">'runtime'</span> =&gt; <span class="code-white">$runtime</span>],
);</code></pre>

                    <p class="request-proof__note">
                        Only the <code>runtime</code> prop travels over the
                        wire. Page state and scroll position stay intact.
                    </p>
                </div>
            </div>

            <div
                id="inertia-scroll"
                class="protocol-proof"
                aria-labelledby="protocol-proof-title"
            >
                <div class="protocol-proof__copy">
                    <span class="protocol-proof__eyebrow"
                        >php-forge/inertia · live scroll</span
                    >
                    <h3 id="protocol-proof-title">
                        Scroll. Fetch. Merge. Stay put.
                    </h3>
                    <p>
                        Move through the trace. When the boundary enters view,
                        Inertia requests only the next slice and the PHP core
                        marks <code>protocolFeed.data</code> for append.
                    </p>

                    <div class="protocol-proof__contract">
                        <span>Server contract</span>
                        <pre><code><span class="code-blue">Inertia</span>::scroll(
    <span class="code-white">$page</span>,
    <span class="code-blue">new</span> <span class="code-green">ScrollMetadata</span>(
        <span class="code-green">'protocol'</span>, <span class="code-white">$prev</span>, <span class="code-white">$next</span>, <span class="code-white">$current</span>,
    ),
);</code></pre>
                    </div>

                    <dl class="protocol-proof__meta">
                        <div>
                            <dt>Prop</dt>
                            <dd><code>scrollProps</code></dd>
                        </div>
                        <div>
                            <dt>Merge path</dt>
                            <dd><code>protocolFeed.data</code></dd>
                        </div>
                    </dl>
                </div>

                <div class="protocol-scroll">
                    <div class="protocol-scroll__bar">
                        <div>
                            <span aria-hidden="true"></span>
                            Protocol trace
                        </div>
                        <code>
                            {{ props.protocolFeed.data.length }} /
                            {{ props.protocolFeed.total }} signals
                        </code>
                    </div>

                    <div
                        class="protocol-scroll__viewport"
                        scroll-region
                        tabindex="0"
                    >
                        <InfiniteScroll
                            data="protocolFeed"
                            as="ol"
                            class="protocol-scroll__items"
                            :buffer="24"
                            only-next
                        >
                            <li
                                v-for="event in props.protocolFeed.data"
                                :key="event.id"
                                class="protocol-scroll__item"
                                :data-accent="event.accent"
                            >
                                <div class="protocol-scroll__index">
                                    {{ String(event.id).padStart(2, "0") }}
                                </div>
                                <div>
                                    <span>{{ event.layer }}</span>
                                    <strong>{{ event.title }}</strong>
                                    <p>{{ event.detail }}</p>
                                </div>
                            </li>

                            <template #next="{ loading, hasMore }">
                                <div
                                    class="protocol-scroll__status"
                                    role="status"
                                    aria-live="polite"
                                >
                                    <span aria-hidden="true"></span>
                                    {{
                                        loading
                                            ? "Requesting the next slice…"
                                            : hasMore
                                              ? "Scroll to cross the next boundary"
                                              : "Protocol trace complete"
                                    }}
                                </div>
                            </template>
                        </InfiniteScroll>
                    </div>

                    <div class="protocol-scroll__footer">
                        <code>{{ page.url }}</code>
                        <code>
                            loaded through {{ props.protocolFeed.page }} /
                            {{ props.protocolFeed.pages }}
                        </code>
                    </div>
                </div>
            </div>
        </section>

        <section id="demo" class="landing-section demo-section">
            <div class="section-intro">
                <div>
                    <span class="section-label">Working reference app</span>
                    <h2>Do not just read it.<br />Follow the flow.</h2>
                </div>
                <p>
                    Every path below opens a real part of the application. Use
                    them to trace how Yii, Inertia, and Vue share responsibility
                    from request to interface.
                </p>
            </div>

            <div class="demo-grid">
                <article
                    v-for="demo in demos"
                    :key="demo.title"
                    class="demo-card"
                >
                    <span>{{ demo.eyebrow }}</span>
                    <h3>{{ demo.title }}</h3>
                    <p>{{ demo.description }}</p>
                    <Link v-if="demo.inertia" :href="demo.href" prefetch>
                        {{ demo.label }}
                        <span aria-hidden="true">→</span>
                    </Link>
                    <a
                        v-else
                        :href="demo.href"
                        :rel="demo.external ? 'noopener noreferrer' : undefined"
                        :target="demo.external ? '_blank' : undefined"
                    >
                        {{ demo.label }}
                        <span aria-hidden="true">{{
                            demo.external ? "↗" : "→"
                        }}</span>
                    </a>
                </article>
            </div>
        </section>

        <section class="release-cta" aria-labelledby="release-cta-heading">
            <div>
                <span class="section-label">Evaluate the next line</span>
                <h2 id="release-cta-heading">
                    Build forward without starting over.
                </h2>
            </div>
            <p>
                Read the migration notes, inspect the branch, then use this
                application as a working map for a modern Yii2 stack.
            </p>
            <div class="release-actions">
                <a
                    class="release-button release-button--light"
                    href="https://github.com/yiisoft/yii2/blob/22.0/framework/UPGRADE-22.md"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    Read the upgrade guide
                </a>
                <a
                    class="release-button release-button--outline-light"
                    href="https://github.com/yiisoft/yii2/tree/22.0"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    Browse branch 22.0
                </a>
            </div>
        </section>
    </div>
</template>
