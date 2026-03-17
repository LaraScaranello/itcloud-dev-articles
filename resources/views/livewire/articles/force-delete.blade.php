<div>
    @if($modal)
        <div
            x-data
            x-on:keydown.escape.window="$wire.set('modal', false)"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div
                class="absolute inset-0 bg-black/50 backdrop-blur-sm dark:bg-black/70"
                wire:click="$set('modal', false)"
            ></div>

            <div class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-2xl
                        dark:border-white/10 dark:bg-zinc-950">
                <div class="border-b border-zinc-200 px-6 py-5 dark:border-white/10">
                    <div class="flex items-start justify-between gap-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full
                                    bg-red-100 text-red-600
                                    dark:bg-red-900/30 dark:text-red-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m0 3.75h.007v.008H12v-.008Zm8.25-3.758c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9Z" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                                Excluir permanentemente
                            </h2>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                Esta ação não poderá ser desfeita.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="$set('modal', false)"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900
                                   dark:border-white/10 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-white"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <p class="text-sm text-zinc-700 dark:text-zinc-300">
                        Tem certeza que deseja excluir permanentemente
                        <span class="font-semibold text-zinc-900 dark:text-white">
                            {{ $article?->title }}
                        </span>?
                    </p>

                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            wire:click="$set('modal', false)"
                            class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 hover:text-zinc-900
                                   dark:border-white/10 dark:text-zinc-300 dark:hover:bg-white/5 dark:hover:text-white"
                        >
                            Cancelar
                        </button>

                        <button
                            type="button"
                            wire:click="delete"
                            class="inline-flex items-center justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-500"
                        >
                            Excluir permanentemente
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
