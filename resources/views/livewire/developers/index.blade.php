<div>
    <div class="mb-10">
        <div class="flex gap-5 justify-between items-center text-2xl font-extrabold">
            Desenvolvedores
        </div>
        <hr class="border-t border-base-content-10 mt-3 border-gray-600">
    </div>

    <div class="flex justify-between mb-4 items-end">
        <div class="w-full flex space-x-4 items-end">
            <div class="w-1/3">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-3 h-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>

                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="Buscar por desenvolvedor ou email"
                        class="border rounded-lg py-2 pr-2 pl-7 placeholder:text-gray-500 placeholder:text-sm w-full border-gray-500"
                    />
                </div>
            </div>

            <select wire:model.live="seniority" class="border rounded-lg pb-2 pt-3 px-4 border-gray-500 text-sm" id="seniority">
                <option value="">Senioridade</option>

                @foreach($seniorities as $seniority)
                    <option value="{{ $seniority->value }}">
                        {{ $seniority->label() }}
                    </option>
                @endforeach
            </select>

            <div id="skills-dropdown"
                x-data="{
                    open: false,
                    selected: @entangle('skills').live
                }"
                class="relative w-48 text-sm"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="border rounded-lg pb-2 pt-3 px-4 border-gray-500 w-full text-left flex justify-between items-center"
                >
                    <span class="truncate">
                        <span x-show="selected.length === 0">Skills</span>
                        <span x-show="selected.length > 0" x-text="`${selected.length} selecionada(s)`"></span>
                    </span>

                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    x-cloak
                    class="absolute z-10 mt-2 w-full border bg-black border-gray-500 rounded-lg max-h-60 overflow-y-auto"
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

            <select wire:model.live="perPage" class="border rounded-lg pb-2 pt-3 px-4 border-gray-500 text-sm" id="perPage">
                <option value="5">5</option>
                <option value="15">15</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

    </div>

    <table class="w-full table-auto border border-gray-500 rounded-lg overflow-hidden text-sm">
        <thead>
            <tr class="text-left border-b border-gray-500">
                <th class="px-4 py-2">
                    <button type="button" wire:click="sortBy('name')" class="flex items-center gap-1 font-semibold">
                        Nome
                        @if($sortField === 'name')
                            <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </button>
                </th>

                <th class="px-4 py-2">
                    <button type="button" wire:click="sortBy('email')" class="flex items-center gap-1 font-semibold">
                        Email
                        @if($sortField === 'email')
                            <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </button>
                </th>

                <th class="px-4 py-2">
                    <button type="button" wire:click="sortBy('seniority')" class="flex items-center gap-1 font-semibold">
                        Senioridade
                        @if($sortField === 'seniority')
                            <span class="text-xs">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </button>
                </th>

                <th class="px-4 py-2">
                    Skills
                </th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($developers as $developer)
                <tr class="hover:bg-zinc-900 border-b border-gray-500">
                    <td class="px-4 py-3">
                        {{ $developer->name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $developer->email }}
                    </td>

                    <td class="px-4 py-3">
                        {{ \App\Enums\Seniority::from($developer->seniority)->label() }}
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                            @foreach($developer->skills as $skill)
                                <span class="text-xs bg-gray-500 text-white px-2 py-1 rounded">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                        Nenhum desenvolvedor encontrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $developers->links() }}

</div>
