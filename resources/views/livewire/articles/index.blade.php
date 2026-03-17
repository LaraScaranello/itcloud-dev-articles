<div class="px-4 sm:px-6 lg:px-0">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-zinc-300">
                Gestão de artigos
            </div>

            <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                Artigos
            </h1>

            <p class="mt-2 max-w-2xl text-sm text-zinc-400">
                Gerencie artigos técnicos, autores vinculados e publicações.
            </p>
        </div>

        <button
            type="button"
            @click="$dispatch('article::create')"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-purple-700 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-purple-600"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            <span>Novo artigo</span>
        </button>
    </div>

    <div class="mb-6 rounded-2xl border border-white/10 bg-zinc-950/80 p-4 shadow-sm sm:p-5">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <div class="sm:col-span-2 xl:col-span-1">
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-zinc-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>

                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="Buscar por título, autor ou data"
                        class="w-full rounded-xl border border-white/10 bg-zinc-900 py-2.5 pr-3 pl-9 text-sm text-white placeholder:text-zinc-500 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    />
                </div>
            </div>

            <div>
                <select
                    wire:model.live="perPage"
                    class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-2.5 text-sm text-white outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                >
                    <option value="5">5 por página</option>
                    <option value="15">15 por página</option>
                    <option value="25">25 por página</option>
                    <option value="50">50 por página</option>
                </select>
            </div>

            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-white/10 bg-zinc-900 px-4 py-2.5 transition hover:bg-zinc-800">
                <input
                    type="checkbox"
                    id="search_trash"
                    wire:model.live="search_trash"
                    class="rounded border-white/20 bg-zinc-800 text-purple-600 focus:ring-purple-500"
                >

                <span class="text-sm text-zinc-200">
                    Mostrar arquivados
                </span>
            </label>
        </div>
    </div>

    {{-- Mobile: lista --}}
    <x-mobile.articles :articles="$articles"/>

    {{-- Desktop/Tablet: cards --}}
    <x-desktop.articles :articles="$articles"/>

    <div class="mt-6">
        {{ $articles->links() }}
    </div>

    <livewire:articles.create />
    <livewire:articles.update />
    <livewire:articles.archive />
    <livewire:articles.restore />
    <livewire:articles.force-delete />
    <livewire:articles.show />
</div>
