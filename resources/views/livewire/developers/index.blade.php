<div class="px-4 sm:px-6 lg:px-0">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-zinc-300">
                Gestão de desenvolvedores
            </div>

            <h1 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                Desenvolvedores
            </h1>

            <p class="mt-2 max-w-2xl text-sm text-zinc-400">
                Gerencie os desenvolvedores cadastrados, aplique filtros, ordene resultados e acompanhe os registros arquivados.
            </p>
        </div>

        <button
            type="button"
            @click="$dispatch('developer::create')"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-purple-700 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-purple-600"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            <span>Novo desenvolvedor</span>
        </button>
    </div>

    <div class="mb-6 rounded-2xl border border-white/10 bg-zinc-950/80 p-4 shadow-sm sm:p-5">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
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
                        placeholder="Buscar por nome ou e-mail"
                        class="w-full rounded-xl border border-white/10 bg-zinc-900 py-2.5 pr-3 pl-9 text-sm text-white placeholder:text-zinc-500 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    />
                </div>
            </div>

            <div>
                <select
                    wire:model.live="seniority"
                    id="seniority"
                    class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-2.5 text-sm text-white outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                >
                    <option value="">Senioridade</option>

                    @foreach($seniorities as $seniority)
                        <option value="{{ $seniority->value }}">
                            {{ $seniority->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div
                id="skills-dropdown"
                x-data="{
                    open: false,
                    selected: @entangle('skills').live
                }"
                class="relative w-full text-sm"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="flex w-full items-center justify-between rounded-xl border border-white/10 bg-zinc-900 py-2.5 pl-4 pr-3 text-left text-white transition hover:bg-zinc-800"
                >
                    <span class="truncate text-sm">
                        <span x-show="selected.length === 0" class="text-zinc-400">Skills</span>
                        <span x-show="selected.length > 0" x-text="`${selected.length} selecionada(s)`"></span>
                    </span>

                    <svg class="ml-2 h-4 w-4 shrink-0 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    x-cloak
                    class="absolute z-20 mt-2 w-full overflow-y-auto rounded-xl border border-white/10 bg-zinc-950 shadow-2xl max-h-60"
                >
                    @foreach($skillsList as $skill)
                        <label class="flex cursor-pointer items-center gap-2 px-4 py-2.5 text-sm text-zinc-200 transition hover:bg-white/5">
                            <input
                                type="checkbox"
                                value="{{ $skill->id }}"
                                x-model="selected"
                                class="rounded border-white/20 bg-zinc-800 text-purple-600 focus:ring-purple-500"
                            >
                            <span>{{ $skill->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <select
                    wire:model.live="perPage"
                    id="perPage"
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

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
        <div class="flex flex-col items-end gap-2 sm:flex-row sm:items-center">
            <span class="text-xs font-medium uppercase tracking-wide text-zinc-500">
                Ordenar por
            </span>

            <div class="flex flex-wrap gap-2">
                <button
                    type="button"
                    wire:click="sortBy('name')"
                    class="inline-flex items-center rounded-xl border px-3 py-2 text-sm transition
                        {{ $sortField === 'name' ? 'border-purple-500 bg-purple-500/10 text-purple-300' : 'border-white/10 bg-zinc-950 text-zinc-300 hover:bg-white/5' }}"
                >
                    Nome
                    @if($sortField === 'name')
                        <span class="ml-1.5">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                    @endif
                </button>

                <button
                    type="button"
                    wire:click="sortBy('email')"
                    class="inline-flex items-center rounded-xl border px-3 py-2 text-sm transition
                        {{ $sortField === 'email' ? 'border-purple-500 bg-purple-500/10 text-purple-300' : 'border-white/10 bg-zinc-950 text-zinc-300 hover:bg-white/5' }}"
                >
                    E-mail
                    @if($sortField === 'email')
                        <span class="ml-1.5">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                    @endif
                </button>

                <button
                    type="button"
                    wire:click="sortBy('seniority')"
                    class="inline-flex items-center rounded-xl border px-3 py-2 text-sm transition
                        {{ $sortField === 'seniority' ? 'border-purple-500 bg-purple-500/10 text-purple-300' : 'border-white/10 bg-zinc-950 text-zinc-300 hover:bg-white/5' }}"
                >
                    Senioridade
                    @if($sortField === 'seniority')
                        <span class="ml-1.5">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                    @endif
                </button>
            </div>
        </div>
    </div>

    @php
        $seniorityColors = [
            'jr' => 'border border-emerald-700 bg-emerald-900/30 text-emerald-300',
            'pl' => 'border border-amber-700 bg-amber-900/30 text-amber-300',
            'sr' => 'border border-purple-700 bg-purple-900/30 text-purple-300',
        ];
    @endphp

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
        @forelse($developers as $developer)
            <div class="group rounded-2xl border border-white/10 bg-zinc-950/80 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-white/15 hover:bg-zinc-900/80">
                <div class="flex h-full flex-col gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <h2 class="text-base text-md font-semibold leading-tight text-white break-words sm:text-md">
                                {{ $developer->name }}
                            </h2>

                            <p class="mt-1 text-sm text-zinc-400 whitespace-nowrap">
                                {{ $developer->email }}
                            </p>
                        </div>

                        <div class="flex shrink-0 flex-wrap justify-end gap-2">
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                {{ $seniorityColors[strtolower($developer->seniority)] ?? 'border border-zinc-700 bg-zinc-800 text-zinc-200' }}">
                                {{ \App\Enums\Seniority::from($developer->seniority)->label() }}
                            </span>

                            <span class="inline-flex items-center rounded-full border border-blue-700 bg-blue-900/30 px-2.5 py-1 text-xs font-medium text-blue-300">
                                {{ $developer->articles_count ?? $developer->articles->count() }} artigo(s)
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="mb-2 block text-xs font-medium uppercase tracking-wide text-zinc-500">
                            Skills
                        </span>

                        <div class="flex flex-wrap gap-2">
                            @forelse($developer->skills as $skill)
                                <span class="rounded-lg border border-white/10 bg-white/5 px-2.5 py-1 text-xs text-zinc-200">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <span class="text-sm text-zinc-500">
                                    Sem skills cadastradas
                                </span>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-auto flex items-center justify-end gap-2 pt-2">
                        @unless($developer->trashed())
                            <button
                                type="button"
                                @click="$dispatch('developer::update', { id: {{ $developer->id }} })"
                                class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-xl border border-white/10 bg-zinc-900 text-zinc-300 transition hover:bg-white/5 hover:text-white"
                                title="Editar desenvolvedor"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </button>

                            <button
                                type="button"
                                @click="$dispatch('developer::archive', { id: {{ $developer->id }} })"
                                class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-xl border border-red-800 bg-red-900/20 text-red-300 transition hover:bg-red-900/35"
                                title="Arquivar desenvolvedor"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.108 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        @else
                            <button
                                type="button"
                                @click="$dispatch('developer::restore', { id: {{ $developer->id }} })"
                                class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-xl border border-emerald-800 bg-emerald-900/20 text-emerald-300 transition hover:bg-emerald-900/35"
                                title="Restaurar desenvolvedor"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                </svg>
                            </button>
                        @endunless
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-white/10 bg-zinc-950/60 px-6 py-12 text-center">
                <div class="mx-auto max-w-md">
                    <h3 class="text-base font-semibold text-white">
                        Nenhum desenvolvedor encontrado
                    </h3>
                    <p class="mt-2 text-sm text-zinc-500">
                        Tente ajustar os filtros, limpar a busca ou cadastrar um novo desenvolvedor.
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $developers->links() }}
    </div>

    <livewire:developers.create />
    <livewire:developers.update />
    <livewire:developers.archive />
    <livewire:developers.restore />
</div>
