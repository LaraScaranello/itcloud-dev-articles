<div>
    @if($modal)
        <div
            x-data
            x-on:keydown.escape.window="$wire.set('modal', false)"
            class="fixed inset-0 z-50 overflow-y-auto"
        >
            <div
                class="fixed inset-0 bg-black/50 backdrop-blur-sm dark:bg-black/70"
                wire:click="$set('modal', false)"
            ></div>

            <div class="relative flex min-h-full items-start justify-center p-4 sm:p-6">
                <div class="relative z-10 my-4 w-full max-w-2xl rounded-2xl border border-zinc-200 bg-white shadow-2xl sm:my-8 dark:border-white/10 dark:bg-zinc-950">
                    <div class="border-b border-zinc-200 px-6 py-5 sm:px-8 dark:border-white/10">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                                    Novo Desenvolvedor
                                </h2>
                                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                    Preencha os dados para cadastrar um novo desenvolvedor.
                                </p>
                            </div>

                            <button
                                type="button"
                                wire:click="$set('modal', false)"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:border-white/10 dark:text-zinc-400 dark:hover:bg-white/5 dark:hover:text-white"
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
                                <label for="name" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                                    Nome
                                </label>
                                <input
                                    id="name"
                                    type="text"
                                    wire:model="form.name"
                                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 dark:border-white/10 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500"
                                    placeholder="Ex.: João Silva"
                                >

                                @error('form.name')
                                    <span class="mt-1 block text-xs text-red-500 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="email" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                                    E-mail
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    wire:model="form.email"
                                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 dark:border-white/10 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500"
                                    placeholder="Ex.: joao@email.com"
                                >

                                @error('form.email')
                                    <span class="mt-1 block text-xs text-red-500 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="seniority" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                                    Senioridade
                                </label>
                                <select
                                    id="seniority"
                                    wire:model="form.seniority"
                                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 dark:border-white/10 dark:bg-zinc-900 dark:text-white"
                                >
                                    <option value="">Selecione</option>

                                    @foreach(\App\Enums\Seniority::cases() as $seniority)
                                        <option value="{{ $seniority->value }}">
                                            {{ $seniority->label() }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('form.seniority')
                                    <span class="mt-1 block text-xs text-red-500 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                                        Skills
                                    </label>

                                    <span class="text-xs text-zinc-500">
                                        Selecione uma ou mais
                                    </span>
                                </div>

                                <div class="max-h-52 overflow-y-auto rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-white/10 dark:bg-zinc-900">
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
                                                    class="inline-flex items-center rounded-full border border-zinc-200 bg-white px-3 py-1.5 text-xs font-medium text-zinc-700 transition
                                                           hover:bg-zinc-100
                                                           peer-checked:border-purple-300
                                                           peer-checked:bg-purple-50
                                                           peer-checked:text-purple-700
                                                           dark:border-white/10
                                                           dark:bg-white/5
                                                           dark:text-zinc-200
                                                           dark:hover:bg-white/10
                                                           dark:peer-checked:border-purple-500
                                                           dark:peer-checked:bg-purple-500/20
                                                           dark:peer-checked:text-purple-300"
                                                >
                                                    {{ $skill->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                @error('form.skills')
                                    <span class="mt-1 block text-xs text-red-500 dark:text-red-400">{{ $message }}</span>
                                @enderror

                                @error('form.skills.*')
                                    <span class="mt-1 block text-xs text-red-500 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-zinc-200 pt-5 sm:flex-row sm:justify-end dark:border-white/10">
                            <button
                                type="button"
                                wire:click="$set('modal', false)"
                                class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-4 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 hover:text-zinc-900 dark:border-white/10 dark:text-zinc-300 dark:hover:bg-white/5 dark:hover:text-white"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-purple-700 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-purple-600"
                            >
                                Salvar desenvolvedor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
