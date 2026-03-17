<div>
    @if($modal)
        <div
            x-data
            x-on:keydown.escape.window="$wire.set('modal', false)"
            class="fixed inset-0 z-50 flex items-center justify-center px-4"
            wire:key="archive-developer-modal"
        >
            <div
                class="absolute inset-0 bg-black/50 backdrop-blur-sm dark:bg-black/70"
                wire:click="$set('modal', false)"
            ></div>

            <div class="relative z-10 w-full max-w-md rounded-2xl border border-zinc-200 bg-white p-6 shadow-xl
                        dark:border-white/10 dark:bg-zinc-950">

                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full
                                bg-red-100 text-red-600
                                dark:bg-red-900/30 dark:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008Zm8.25-3.758c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9Z" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Arquivar desenvolvedor
                        </h2>

                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                            Tem certeza que deseja arquivar
                            <span class="font-medium text-zinc-900 dark:text-white">
                                {{ $developer?->name }}
                            </span>?
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        wire:click="$set('modal', false)"
                        class="inline-flex items-center justify-center rounded-lg border border-zinc-300 px-4 py-2.5 text-sm text-zinc-700 transition hover:bg-zinc-100 hover:text-zinc-900
                               dark:border-white/10 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white"
                    >
                        Cancelar
                    </button>

                    <button
                        type="button"
                        wire:click="archive"
                        class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm text-red-700 transition hover:bg-red-100
                               dark:border-red-800 dark:bg-red-900/30 dark:text-red-300 dark:hover:bg-red-900/50"
                    >
                        Arquivar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
