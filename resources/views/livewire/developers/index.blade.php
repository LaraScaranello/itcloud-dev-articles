<div class="px-4 sm:px-6 lg:px-0">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold">Desenvolvedores</h1>
            <p class="text-sm text-gray-400 mt-1">
                Gerencie os desenvolvedores cadastrados, filtros e ordenação.
            </p>
        </div>

        <button
            type="button"
            @click="$dispatch('developer::create')"
            class="border rounded-lg border-purple-800 bg-purple-800 text-sm py-2.5 px-4 cursor-pointer transition hover:bg-purple-700 flex items-center justify-center gap-2"
        >
            <span>+</span>
            <span>Novo Desenvolvedor</span>
        </button>
    </div>

    <div class="mb-6 rounded-2xl border border-gray-800 bg-zinc-950/60 p-4 sm:p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="sm:col-span-2 xl:col-span-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>

                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="Buscar por desenvolvedor ou email"
                        class="w-full border rounded-lg py-2.5 pr-3 pl-9 placeholder:text-gray-500 placeholder:text-sm text-sm border-gray-500"
                    />
                </div>
            </div>

            <div>
                <select
                    wire:model.live="seniority"
                    id="seniority"
                    class="w-full border rounded-lg py-2.5 px-4 border-gray-500 text-sm"
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
                    class="w-full border rounded-lg py-2.5 pl-4 border-gray-500 text-left flex justify-between items-center"
                >
                    <span class="truncate">
                        <span x-show="selected.length === 0">Skills</span>
                        <span x-show="selected.length > 0" x-text="`${selected.length} selecionada(s)`"></span>
                    </span>

                    <svg class="w-3 h-4 ml-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    x-cloak
                    class="absolute z-20 mt-2 w-full border bg-black border-gray-500 rounded-lg max-h-60 overflow-y-auto shadow-lg"
                >
                    @foreach($skillsList as $skill)
                        <label class="flex items-center gap-2 px-4 py-2 hover:bg-zinc-800 cursor-pointer">
                            <input
                                type="checkbox"
                                value="{{ $skill->id }}"
                                x-model="selected"
                                class="rounded border-gray-400"
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
                    class="w-full border rounded-lg py-2.5 px-4 border-gray-500 text-sm"
                >
                    <option value="5">5 por página</option>
                    <option value="15">15 por página</option>
                    <option value="25">25 por página</option>
                    <option value="50">50 por página</option>
                </select>
            </div>
        </div>
    </div>

    <div class="mb-4 flex flex-col items-end sm:flex-row sm:items-center sm:justify-end gap-3">
        <div class="flex flex-wrap gap-2">
            <button
                type="button"
                wire:click="sortBy('name')"
                class="rounded-lg border px-3 py-2 text-sm transition
                    {{ $sortField === 'name' ? 'border-purple-700 bg-purple-900/30 text-purple-300' : 'border-gray-500 hover:bg-zinc-800' }}"
            >
                Nome
                @if($sortField === 'name')
                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                @endif
            </button>

            <button
                type="button"
                wire:click="sortBy('email')"
                class="rounded-lg border px-3 py-2 text-sm transition
                    {{ $sortField === 'email' ? 'border-purple-700 bg-purple-900/30 text-purple-300' : 'border-gray-500 hover:bg-zinc-800' }}"
            >
                E-mail
                @if($sortField === 'email')
                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                @endif
            </button>

            <button
                type="button"
                wire:click="sortBy('seniority')"
                class="rounded-lg border px-3 py-2 text-sm transition
                    {{ $sortField === 'seniority' ? 'border-purple-700 bg-purple-900/30 text-purple-300' : 'border-gray-500 hover:bg-zinc-800' }}"
            >
                Senioridade
                @if($sortField === 'seniority')
                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                @endif
            </button>
        </div>
    </div>

    @php
        $seniorityColors = [
            'jr' => 'bg-emerald-900/40 text-emerald-300 border border-emerald-700',
            'pl' => 'bg-amber-900/40 text-amber-300 border border-amber-700',
            'sr' => 'bg-purple-900/40 text-purple-300 border border-purple-700',
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
        @forelse($developers as $developer)
            <div class="border border-gray-500 rounded-xl p-4 sm:p-5 bg-zinc-950/40 hover:bg-zinc-900/40 transition">
                <div class="flex flex-col gap-4 h-full">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold wrap-break-word">
                                {{ $developer->name }}
                            </h2>

                            <p class="text-sm text-gray-400 break-all mt-1">
                                {{ $developer->email }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2 shrink-0">
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                                {{ $seniorityColors[strtolower($developer->seniority)] ?? 'bg-zinc-800 text-zinc-200 border border-zinc-700' }}">
                                {{ \App\Enums\Seniority::from($developer->seniority)->label() }}
                            </span>

                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-blue-900/40 text-blue-300 border border-blue-700">
                                {{ $developer->articles_count ?? $developer->articles->count() }} artigo(s)
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs text-gray-400 block mb-2">Skills</span>

                        <div class="flex flex-wrap gap-2">
                            @forelse($developer->skills as $skill)
                                <span class="text-xs bg-gray-700 text-white px-2 py-1 rounded-md">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-500">
                                    Sem skills cadastradas
                                </span>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-auto pt-2 flex gap-2 sm:justify-end">
                        <button
                            type="button"
                            class="flex-1 sm:flex-none border border-gray-600 rounded-lg px-4 py-2 text-sm hover:bg-zinc-700 transition flex items-center justify-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>

                        <button
                            type="button"
                            class="flex-1 sm:flex-none border border-red-800 bg-red-900/30 text-red-300 rounded-lg px-4 py-2 text-sm hover:bg-red-900/50 transition flex items-center justify-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full border border-gray-500 rounded-xl p-6 text-center text-gray-400">
                Nenhum desenvolvedor encontrado.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $developers->links() }}
    </div>

    <livewire:developers.create/>
</div>
