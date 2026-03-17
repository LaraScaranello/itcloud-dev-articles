<div class="hidden gap-4 md:grid md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
    @forelse($articles as $article)
        <div class="group flex h-full flex-col rounded-2xl border border-white/10 bg-zinc-950/80 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-white/15 hover:bg-zinc-900/80">
            @if($article->cover_image)
                @php
                    $cover = str_starts_with($article->cover_image, 'http')
                        ? $article->cover_image
                        : Storage::url($article->cover_image);
                @endphp

                @if($cover)
                    <div class="mb-4 overflow-hidden rounded-xl border border-white/10">
                        <img
                            src="{{ $cover }}"
                            alt="{{ $article->title }}"
                            class="h-40 w-full object-cover"
                        >
                    </div>
                @endif
            @endif

            <div class="mb-4 flex items-center justify-between gap-2">
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center rounded-full border border-blue-700 bg-blue-900/30 px-2.5 py-1 text-xs font-medium text-blue-300">
                        {{ $article->developers_count }} autor(es)
                    </span>

                    @if($article->published_at)
                        <span class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-2.5 py-1 text-xs font-medium text-zinc-300">
                            {{ \Illuminate\Support\Carbon::parse($article->published_at)->format('d/m/Y') }}
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full border border-amber-700 bg-amber-900/30 px-2.5 py-1 text-xs font-medium text-amber-300">
                            Não publicado
                        </span>
                    @endif
                </div>
            </div>

            <div class="min-w-0">
                <h2 class="text-lg font-semibold leading-snug text-white line-clamp-3">
                    {{ $article->title }}
                </h2>

                <p class="mt-2 text-xs text-zinc-500 truncate">
                    {{ $article->slug }}
                </p>
            </div>

            <div class="mt-4">
                <p class="text-sm leading-6 text-zinc-400 line-clamp-4">
                    {{ strip_tags($article->content) }}
                </p>
            </div>

            <div class="mt-5">
                <span class="mb-2 block text-xs font-medium uppercase tracking-wide text-zinc-500">
                    Autores
                </span>

                <div class="flex flex-wrap gap-2">
                    @forelse($article->developers->take(3) as $developer)
                        <span class="rounded-lg border border-white/10 bg-white/5 px-2.5 py-1 text-xs text-zinc-200">
                            {{ $developer->name }}
                        </span>
                    @empty
                        <span class="text-sm text-zinc-500">
                            Sem desenvolvedores vinculados
                        </span>
                    @endforelse

                    @if($article->developers->count() > 3)
                        <span class="rounded-lg border border-white/10 bg-white/5 px-2.5 py-1 text-xs text-zinc-400">
                            +{{ $article->developers->count() - 3 }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-auto flex items-center justify-end gap-2 pt-5">
                <button
                    type="button"
                    @click="$dispatch('article::update', { id: {{ $article->id }} })"
                    class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-xl border border-white/10 bg-zinc-900 text-zinc-300 transition hover:bg-white/5 hover:text-white"
                    title="Editar artigo"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </button>

                <button
                    type="button"
                    @click="$dispatch('article::archive', { id: {{ $article->id }} })"
                    class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-xl border border-red-800 bg-red-900/20 text-red-300 transition hover:bg-red-900/35"
                    title="Excluir artigo"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.108 0 0 0-7.5 0" />
                    </svg>
                </button>
            </div>
        </div>
    @empty
        <div class="col-span-full rounded-2xl border border-dashed border-white/10 bg-zinc-950/60 px-6 py-12 text-center">
            <div class="mx-auto max-w-md">
                <h3 class="text-base font-semibold text-white">
                    Nenhum artigo encontrado
                </h3>
                <p class="mt-2 text-sm text-zinc-500">
                    Tente ajustar a busca ou cadastrar um novo artigo.
                </p>
            </div>
        </div>
    @endforelse
</div>
