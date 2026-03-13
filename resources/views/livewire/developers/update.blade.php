<div>
    @if($modal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
            <div class="bg-zinc-900 border border-gray-700 rounded-lg w-full max-w-lg p-8">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Novo Desenvolvedor</h2>

                    <button
                        wire:click="$set('modal', false)"
                        class="text-gray-400 hover:text-white"
                    >
                        ✕
                    </button>
                </div>

                <hr class="border-t my-3 border-gray-600">

                <form wire:submit.prevent="save" class="space-y-5">
                    <div id="name">
                        <label class="block text-sm mb-1">Nome</label>
                        <input
                            type="text"
                            wire:model="form.name"
                            class="w-full border border-gray-600 bg-zinc-800 rounded-lg px-3 py-2"
                        >

                        @error('form.name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="email">
                        <label class="block text-sm mb-1">Email</label>
                        <input
                            type="email"
                            wire:model="form.email"
                            class="w-full border border-gray-600 bg-zinc-800 rounded-lg px-3 py-2"
                        >

                        @error('form.email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="seniority">
                        <label class="block text-sm mb-1">Senioridade</label>
                        <select
                            wire:model="form.seniority"
                            class="w-full border border-gray-600 bg-zinc-800 rounded-lg px-3 py-2"
                        >
                            <option value="">Selecione</option>

                            @foreach(\App\Enums\Seniority::cases() as $seniority)
                                <option value="{{ $seniority->value }}">
                                    {{ $seniority->label() }}
                                </option>
                            @endforeach
                        </select>

                        @error('form.seniority')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="skills">
                        <label class="block text-sm mb-2">Skills</label>
                        <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto">
                            @foreach(\App\Models\Skill::orderBy('name')->get() as $skill)
                                <label class="flex items-center gap-2 text-sm">
                                    <input
                                        type="checkbox"
                                        value="{{ $skill->id }}"
                                        wire:model="form.skills"
                                        class="rounded"
                                    >
                                    {{ $skill->name }}
                                </label>
                            @endforeach
                        </div>

                        @error('form.skills')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror

                        @error('form.skills.*')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button
                            type="button"
                            wire:click="$set('modal', false)"
                            class="border border-gray-600 px-4 py-2 rounded-lg"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="bg-purple-700 text-white px-4 py-2 rounded-lg"
                        >
                            Salvar
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif
</div>
