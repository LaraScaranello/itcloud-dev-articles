<div>
    @if($modal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center px-4"
            wire:key="restore-developer-modal"
        >
            <div
                class="absolute inset-0 bg-black/70"
                wire:click="$set('modal', false)"
            ></div>

            <div class="relative z-10 w-full max-w-md rounded-2xl border border-gray-800 bg-zinc-950 p-6 shadow-xl">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-900/30 text-emerald-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75 9.75 19.5l-3.75-3.75m13.5-9a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <h2 class="text-lg font-semibold text-white">
                            Restaurar desenvolvedor
                        </h2>

                        <p class="mt-2 text-sm text-gray-400">
                            Tem certeza que deseja restaurar
                            <span class="font-medium text-white">
                                {{ $developer?->name }}
                            </span>?
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        wire:click="$set('modal', false)"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-700 px-4 py-2.5 text-sm text-white transition hover:bg-zinc-800"
                    >
                        Cancelar
                    </button>

                    <button
                        type="button"
                        wire:click="restore"
                        class="inline-flex items-center justify-center rounded-lg border border-emerald-800 bg-emerald-900/30 px-4 py-2.5 text-sm text-emerald-300 transition hover:bg-emerald-900/50"
                    >
                        Restaurar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
