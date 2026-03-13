<div>
    @if($modal)
        <div
            x-data
            x-on:keydown.escape.window="$wire.set('modal', false)"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div
                class="absolute inset-0 bg-black/70 backdrop-blur-sm"
                wire:click="$set('modal', false)"
            ></div>

            <div class="relative z-10 w-full max-w-2xl overflow-hidden rounded-2xl border border-white/10 bg-zinc-950 shadow-2xl">
                <div class="border-b border-white/10 px-6 py-5 sm:px-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-white">
                                Editar desenvolvedor
                            </h2>
                            <p class="mt-1 text-sm text-zinc-400">
                                Atualize os dados do desenvolvedor selecionado.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="$set('modal', false)"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-zinc-400 transition hover:bg-white/5 hover:text-white"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="save" class="px-6 py-6 sm:px-8">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="mb-2 block text-sm font-medium text-zinc-200">
                                Nome
                            </label>
                            <input
                                id="name"
                                type="text"
                                wire:model="form.name"
                                class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-3 text-sm text-white placeholder:text-zinc-500 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                                placeholder="Ex.: João Silva"
                            >

                            @error('form.name')
                                <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="email" class="mb-2 block text-sm font-medium text-zinc-200">
                                E-mail
                            </label>
                            <input
                                id="email"
                                type="email"
                                wire:model="form.email"
                                class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-3 text-sm text-white placeholder:text-zinc-500 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                                placeholder="Ex.: joao@email.com"
                            >

                            @error('form.email')
                                <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="seniority" class="mb-2 block text-sm font-medium text-zinc-200">
                                Senioridade
                            </label>
                            <select
                                id="seniority"
                                wire:model="form.seniority"
                                class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-3 text-sm text-white outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            >
                                <option value="">Selecione</option>

                                @foreach(\App\Enums\Seniority::cases() as $seniority)
                                    <option value="{{ $seniority->value }}">
                                        {{ $seniority->label() }}
                                    </option>
                                @endforeach
                            </select>

                            @error('form.seniority')
                                <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <div class="mb-2 flex items-center justify-between gap-3">
                                <label class="block text-sm font-medium text-zinc-200">
                                    Skills
                                </label>

                                <span class="text-xs text-zinc-500">
                                    Selecione uma ou mais
                                </span>
                            </div>

                            <div class="max-h-52 overflow-y-auto rounded-xl border border-white/10 bg-zinc-900 p-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($skillsList as $skill)
                                        <label class="cursor-pointer">
                                            <input
                                                type="checkbox"
                                                value="{{ $skill->id }}"
                                                wire:model="form.skills"
                                                class="peer hidden"
                                            >

                                            <span
                                                class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-zinc-200 transition
                                                       hover:bg-white/10
                                                       peer-checked:border-purple-500
                                                       peer-checked:bg-purple-500/20
                                                       peer-checked:text-purple-300"
                                            >
                                                {{ $skill->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            @error('form.skills')
                                <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                            @enderror

                            @error('form.skills.*')
                                <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-white/10 pt-5 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            wire:click="$set('modal', false)"
                            class="inline-flex items-center justify-center rounded-xl border border-white/10 px-4 py-2.5 text-sm font-medium text-zinc-300 transition hover:bg-white/5 hover:text-white"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-purple-700 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-purple-600"
                        >
                            Salvar alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
