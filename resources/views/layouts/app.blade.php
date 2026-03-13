<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main container>
        {{ $slot }}
    </flux:main>

    {{-- Toast container --}}
    <div
        x-data="toastComponent()"
        x-on:toast.window="show($event.detail.message, $event.detail.type)"
        class="fixed bottom-5 right-5 z-50 space-y-2"
    >
        <template x-for="toast in toasts" :key="toast.id">
            <div
                x-show="toast.show"
                x-transition
                class="px-4 py-3 rounded-lg shadow-lg text-white flex items-center gap-2"
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

    <script>
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

</x-layouts::app.sidebar>
