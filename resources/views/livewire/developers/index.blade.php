<div class="px-4 sm:px-6 lg:px-0">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700 dark:border-white/10 dark:bg-white/5 dark:text-zinc-300">
                Gestão de desenvolvedores
            </div>

            <h1 class="mt-3 text-2xl font-semibold tracking-tight text-zinc-900 sm:text-3xl dark:text-white">
                Desenvolvedores
            </h1>

            <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400">
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

    <div class="mb-6 rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm sm:p-5 dark:border-white/10 dark:bg-zinc-950/80">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <div class="sm:col-span-2 xl:col-span-1">
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-zinc-400 dark:text-zinc-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>

                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="Buscar por nome ou e-mail"
                        class="w-full rounded-xl border border-zinc-300 bg-white py-2.5 pr-3 pl-9 text-sm text-zinc-900 placeholder:text-zinc-400 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 dark:border-white/10 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500"
                    />
                </div>
            </div>

            <div>
                <select
                    wire:model.live="seniority"
                    id="seniority"
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 dark:border-white/10 dark:bg-zinc-900 dark:text-white"
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
                    class="flex w-full items-center justify-between rounded-xl border border-zinc-300 bg-white py-2.5 pl-4 pr-3 text-left text-zinc-900 transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:text-white dark:hover:bg-zinc-800"
                >
                    <span class="truncate text-sm">
                        <span x-show="selected.length === 0" class="text-zinc-500 dark:text-zinc-400">Skills</span>
                        <span x-show="selected.length > 0" x-text="`${selected.length} selecionada(s)`"></span>
                    </span>

                    <svg class="ml-2 h-4 w-4 shrink-0 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    x-cloak
                    class="absolute z-20 mt-2 max-h-60 w-full overflow-y-auto rounded-xl border border-zinc-200 bg-white shadow-2xl dark:border-white/10 dark:bg-zinc-950"
                >
                    @foreach($skillsList as $skill)
                        <label class="flex cursor-pointer items-center gap-2 px-4 py-2.5 text-sm text-zinc-700 transition hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-white/5">
                            <input
                                type="checkbox"
                                value="{{ $skill->id }}"
                                x-model="selected"
                                class="rounded border-zinc-300 bg-white text-purple-600 focus:ring-purple-500 dark:border-white/20 dark:bg-zinc-800"
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
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 dark:border-white/10 dark:bg-zinc-900 dark:text-white"
                >
                    <option value="5">5 por página</option>
                    <option value="15">15 por página</option>
                    <option value="25">25 por página</option>
                    <option value="50">50 por página</option>
                </select>
            </div>

            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-zinc-300 bg-white px-4 py-2.5 transition hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-900 dark:hover:bg-zinc-800">
                <input
                    type="checkbox"
                    id="search_trash"
                    wire:model.live="search_trash"
                    class="rounded border-zinc-300 bg-white text-purple-600 focus:ring-purple-500 dark:border-white/20 dark:bg-zinc-800"
                >

                <span class="text-sm text-zinc-700 dark:text-zinc-200">
                    Mostrar arquivados
                </span>
            </label>
        </div>
    </div>

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
        <div class="flex flex-col items-end gap-2 sm:flex-row sm:items-center">
            <span class="text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-500">
                Ordenar por
            </span>

            <div class="flex flex-wrap gap-2">
                <button
                    type="button"
                    wire:click="sortBy('name')"
                    class="inline-flex items-center rounded-xl border px-3 py-2 text-sm transition
                        {{ $sortField === 'name'
                            ? 'border-purple-500 bg-purple-500/10 text-purple-600 dark:text-purple-300'
                            : 'border-zinc-300 bg-white text-zinc-700 hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-950 dark:text-zinc-300 dark:hover:bg-white/5' }}"
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
                        {{ $sortField === 'email'
                            ? 'border-purple-500 bg-purple-500/10 text-purple-600 dark:text-purple-300'
                            : 'border-zinc-300 bg-white text-zinc-700 hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-950 dark:text-zinc-300 dark:hover:bg-white/5' }}"
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
                        {{ $sortField === 'seniority'
                            ? 'border-purple-500 bg-purple-500/10 text-purple-600 dark:text-purple-300'
                            : 'border-zinc-300 bg-white text-zinc-700 hover:bg-zinc-50 dark:border-white/10 dark:bg-zinc-950 dark:text-zinc-300 dark:hover:bg-white/5' }}"
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
            'jr' => 'border border-teal-200 bg-teal-50 text-teal-700 dark:border-teal-700 dark:bg-teal-900/30 dark:text-teal-300',
            'pl' => 'border border-orange-200 bg-orange-50 text-orange-700 dark:border-orange-700 dark:bg-orange-900/30 dark:text-orange-300',
            'sr' => 'border border-violet-200 bg-violet-50 text-violet-700 dark:border-violet-700 dark:bg-violet-900/30 dark:text-violet-300',
        ];
    @endphp

    {{-- Mobile: lista --}}
    <x-mobile.developers :developers="$developers" :seniority-colors="$seniorityColors"/>

    {{-- Desktop/Tablet: cards --}}
    <x-desktop.developers :developers="$developers" :seniority-colors="$seniorityColors"/>

    <div class="mt-6">
        {{ $developers->links() }}
    </div>

    <livewire:developers.create />
    <livewire:developers.update />
    <livewire:developers.archive />
    <livewire:developers.restore />
    <livewire:developers.force-delete />
</div>
