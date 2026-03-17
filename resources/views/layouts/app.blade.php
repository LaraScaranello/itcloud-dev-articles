<div
    x-data="themeSwitcher()"
    x-init="init()"
    class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-white"
>
    <x-layouts::app.sidebar :title="$title ?? null">

        <div class="fixed right-4 top-4 z-40">
            <button
                type="button"
                @click="toggle()"
                class="rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-700 shadow-sm transition hover:bg-zinc-100 dark:border-white/10 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-white/5"
            >
                <span x-show="theme === 'dark'">☀️</span>
                <span x-show="theme === 'light'">🌙</span>
            </button>
        </div>

        <flux:main class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </flux:main>

        <div
            x-data="toastComponent()"
            x-on:toast.window="show($event.detail.message, $event.detail.type)"
            class="fixed bottom-5 right-5 z-50 space-y-2"
        >
            <template x-for="toast in toasts" :key="toast.id">
                <div
                    x-show="toast.show"
                    x-transition
                    class="flex items-center gap-2 rounded-lg px-4 py-3 text-white shadow-lg"
                    :class="{
                        'bg-green-600': toast.type === 'success',
                        'bg-red-600': toast.type === 'error',
                        'bg-blue-600': toast.type === 'info'
                    }"
                >
                    <span x-text="toast.message"></span>
                </div>
            </template>
        </div>

    </x-layouts::app.sidebar>
</div>

<script>
    function themeSwitcher() {
        return {
            theme: 'dark',

            init() {
                const saved = localStorage.getItem('theme')

                if (saved) {
                    this.theme = saved
                } else {
                    this.theme = window.matchMedia('(prefers-color-scheme: dark)').matches
                        ? 'dark'
                        : 'light'
                }

                this.applyTheme()
            },

            toggle() {
                this.theme = this.theme === 'dark' ? 'light' : 'dark'
                localStorage.setItem('theme', this.theme)
                this.applyTheme()
            },

            applyTheme() {
                if (this.theme === 'dark') {
                    document.documentElement.classList.add('dark')
                } else {
                    document.documentElement.classList.remove('dark')
                }
            }
        }
    }

    function toastComponent() {
        return {
            toasts: [],

            show(message, type = 'success') {
                const id = Date.now()

                this.toasts.push({
                    id,
                    message,
                    type,
                    show: true
                })

                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id)
                }, 3000)
            }
        }
    }
</script>
