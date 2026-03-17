<div>
    @if($modal)
        <div
            x-data
            x-on:keydown.escape.window="$wire.set('modal', false)"
            class="fixed inset-0 z-50 overflow-y-auto"
            >
            <div
                class="fixed inset-0 bg-black/70 backdrop-blur-sm"
                wire:click="$set('modal', false)"
            ></div>

            <div class="relative flex min-h-full items-start justify-center p-4 sm:p-6">
                <div class="relative z-10 my-4 w-full max-w-3xl rounded-2xl border border-white/10 bg-zinc-950 shadow-2xl sm:my-8">
                    <div class="border-b border-white/10 px-6 py-5 sm:px-8">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-white">
                                    Editar Artigo
                                </h2>
                                <p class="mt-1 text-sm text-zinc-400">
                                    Atualize os dados do artigo e salve as alterações.
                                </p>
                            </div>

                            <button
                                type="button"
                                wire:click="$set('modal', false)"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-zinc-400 transition hover:bg-white/5 hover:text-white"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form wire:submit.prevent="save" class="px-6 py-6 sm:px-8">
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="title" class="mb-2 block text-sm font-medium text-zinc-200">
                                    Título
                                </label>
                                <input
                                    id="title"
                                    type="text"
                                    wire:model="form.title"
                                    class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-3 text-sm text-white placeholder:text-zinc-500 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                                    placeholder="Ex.: Boas práticas com Laravel e Livewire"
                                >

                                @error('form.title')
                                    <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="content" class="mb-2 block text-sm font-medium text-zinc-200">
                                    Conteúdo HTML
                                </label>
                                <textarea
                                    id="content"
                                    rows="10"
                                    wire:model="form.content"
                                    class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-3 font-mono text-sm text-white placeholder:text-zinc-500 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                                    placeholder="<h2>Título da seção</h2><p>Seu conteúdo aqui...</p>"
                                ></textarea>

                                <p class="mt-2 text-xs text-zinc-500">
                                    Você pode editar o conteúdo usando HTML, como headings, parágrafos, listas e blocos de código.
                                </p>

                                @error('form.content')
                                    <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="published_at" class="mb-2 block text-sm font-medium text-zinc-200">
                                    Data de publicação
                                </label>
                                <input
                                    id="published_at"
                                    type="date"
                                    wire:model="form.published_at"
                                    class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-3 text-sm text-white outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                                >

                                @error('form.published_at')
                                    <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="sm:col-span-2 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                @if($form->cover_image)
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-zinc-200">
                                            Nova capa
                                        </label>

                                        <div class="flex items-start gap-4 rounded-xl border border-purple-500/30 bg-purple-500/5 p-3">
                                            <div class="h-24 w-36 shrink-0 overflow-hidden rounded-lg border border-white/10 bg-zinc-950">
                                                <img
                                                    src="{{ $form->cover_image->temporaryUrl() }}"
                                                    alt="Nova capa"
                                                    class="h-full w-full object-cover"
                                                >
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-white">
                                                    Nova imagem selecionada
                                                </p>

                                                <p class="mt-1 text-xs text-zinc-400">
                                                    Esta imagem será usada quando você salvar as alterações.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($form->article?->cover_image)
                                    @php
                                        $currentCover = str_starts_with($form->article->cover_image, 'http')
                                            ? $form->article->cover_image
                                            : Storage::url($form->article->cover_image);
                                    @endphp

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-zinc-200">
                                            Capa atual
                                        </label>

                                        <div class="flex items-start gap-4 rounded-xl border border-white/10 bg-zinc-900/60 p-3">
                                            <div class="h-24 w-36 shrink-0 overflow-hidden rounded-lg border border-white/10 bg-zinc-950">
                                                <img
                                                    src="{{ $currentCover }}"
                                                    alt="{{ $form->title }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-white">
                                                    {{ $form->title }}
                                                </p>

                                                <p class="mt-1 text-xs text-zinc-500">
                                                    Esta é a capa atualmente vinculada ao artigo.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div>
                                    <label for="cover_image" class="mb-2 block text-sm font-medium text-zinc-200">
                                        Nova imagem de capa
                                    </label>
                                    <input
                                        id="cover_image"
                                        type="file"
                                        wire:model="form.cover_image"
                                        class="block w-full text-sm text-zinc-300 file:mr-4 file:rounded-lg file:border-0 file:bg-purple-700 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-purple-600"
                                    >

                                    <p class="mt-2 text-xs text-zinc-500">
                                        Envie uma nova imagem apenas se quiser substituir a capa atual.
                                    </p>

                                    @error('form.cover_image')
                                        <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="sm:col-span-2"
                                wire:ignore.self
                                x-data="developersSelect(
                                    $wire,
                                    @js($form->developers),
                                    @js(
                                        $developersList->map(fn ($developer) => [
                                            'id' => $developer->id,
                                            'name' => $developer->name,
                                        ])->values()
                                    )
                                )"
                                @click.outside="open = false"
                            >
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <label class="block text-sm font-medium text-zinc-200">
                                        Desenvolvedores
                                    </label>

                                    <span class="text-xs text-zinc-500">
                                        Atualize os autores vinculados ao artigo
                                    </span>
                                </div>

                                <div class="relative">
                                    <button
                                        type="button"
                                        @click="open = !open; if (open) { $nextTick(() => $refs.searchInput.focus()) }"
                                        class="flex w-full items-center justify-between rounded-xl border border-white/10 bg-zinc-900 px-4 py-3 text-left text-sm text-white outline-none transition hover:border-white/20 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                                    >
                                        <div class="min-w-0 flex-1">
                                            <template x-if="selectedDevelopers().length === 0">
                                                <span class="text-zinc-500">Selecione desenvolvedores</span>
                                            </template>

                                            <template x-if="selectedDevelopers().length > 0">
                                                <div class="flex items-center gap-2 overflow-hidden">
                                                    <span class="truncate" x-text="selectedSummary()"></span>

                                                    <span
                                                        class="shrink-0 rounded-full border border-purple-500/40 bg-purple-500/10 px-2 py-0.5 text-xs text-purple-300"
                                                        x-text="selectedDevelopers().length"
                                                    ></span>
                                                </div>
                                            </template>
                                        </div>

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.8"
                                            stroke="currentColor"
                                            class="ml-3 h-4 w-4 shrink-0 text-zinc-400 transition"
                                            :class="{ 'rotate-180': open }"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>

                                    <div
                                        x-show="open"
                                        x-transition.origin.top
                                        x-cloak
                                        class="absolute z-40 mt-2 w-full overflow-hidden rounded-xl border border-white/10 bg-zinc-950 shadow-2xl"
                                    >
                                        <div class="border-b border-white/10 p-3">
                                            <div class="relative">
                                                <input
                                                    x-ref="searchInput"
                                                    type="text"
                                                    x-model="search"
                                                    placeholder="Pesquisar desenvolvedor..."
                                                    class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-2.5 pr-10 text-sm text-white placeholder:text-zinc-500 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                                                >

                                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-zinc-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="max-h-64 overflow-y-auto p-2">
                                            <template x-if="selectedDevelopers().length > 0">
                                                <div class="mb-2 border-b border-white/10 pb-2">
                                                    <div class="mb-2 px-2 text-[11px] font-medium uppercase tracking-wide text-zinc-500">
                                                        Selecionados
                                                    </div>

                                                    <div class="space-y-1">
                                                        <template x-for="developer in selectedDevelopers()" :key="'selected-' + developer.id">
                                                            <button
                                                                type="button"
                                                                @click="remove(developer.id)"
                                                                class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm text-purple-300 transition hover:bg-white/5"
                                                            >
                                                                <span x-text="developer.name"></span>
                                                                <span class="text-xs text-purple-400">Remover</span>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            <div class="mb-2 px-2 text-[11px] font-medium uppercase tracking-wide text-zinc-500">
                                                Disponíveis
                                            </div>

                                            <div class="space-y-1">
                                                <template x-for="developer in filteredDevelopers()" :key="'available-' + developer.id">
                                                    <button
                                                        type="button"
                                                        @click="toggle(developer.id)"
                                                        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm text-zinc-200 transition hover:bg-white/5"
                                                    >
                                                        <span x-text="developer.name"></span>

                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4 text-zinc-500">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                                        </svg>
                                                    </button>
                                                </template>

                                                <div
                                                    x-show="filteredDevelopers().length === 0"
                                                    class="px-3 py-2 text-sm text-zinc-500"
                                                >
                                                    Nenhum desenvolvedor encontrado.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @error('form.developers')
                                    <span class="mt-1 block text-xs text-red-400">{{ $message }}</span>
                                @enderror

                                @error('form.developers.*')
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
                                Atualizar artigo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function developersSelect($wire, initialSelected, developers) {
        return {
            open: false,
            search: '',
            developers,
            selected: Array.isArray(initialSelected) ? initialSelected.map(Number) : [],

            sync() {
                $wire.set('form.developers', [...this.selected])
            },

            toggle(id) {
                id = Number(id)

                if (this.isSelected(id)) {
                    this.selected = this.selected.filter(item => Number(item) !== id)
                } else {
                    this.selected = [...this.selected, id]
                }

                this.sync()
            },

            remove(id) {
                id = Number(id)
                this.selected = this.selected.filter(item => Number(item) !== id)
                this.sync()
            },

            isSelected(id) {
                id = Number(id)
                return this.selected.some(item => Number(item) === id)
            },

            filteredDevelopers() {
                return this.developers.filter(developer =>
                    !this.isSelected(developer.id) &&
                    developer.name.toLowerCase().includes(this.search.toLowerCase())
                )
            },

            selectedDevelopers() {
                return this.developers.filter(developer => this.isSelected(developer.id))
            },

            selectedSummary() {
                const names = this.selectedDevelopers().map(developer => developer.name)

                if (names.length <= 2) {
                    return names.join(', ')
                }

                return `${names[0]}, ${names[1]} +${names.length - 2}`
            },

            init() {
                this.sync()
            }
        }
    }
</script>
