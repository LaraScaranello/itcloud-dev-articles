<div class="space-y-3 md:hidden">
    @forelse($articles as $article)
        <div class="border-b border-white/10 py-4 last:border-b-0">
            <div class="flex items-start gap-3">
                @if($article->cover_image)
                    @php
                        $cover = str_starts_with($article->cover_image, 'http')
                            ? $article->cover_image
                            : Storage::url($article->cover_image);
                    @endphp

                    <img
                        src="{{ $cover }}"
                        alt="{{ $article->title }}"
                        class="h-16 w-20 flex-shrink-0 rounded-lg object-cover"
                    >
                @endif

                <div class="min-w-0 flex-1">
                    <h2 class="text-base font-semibold leading-snug text-white break-words">
                        {{ $article->title }}
                    </h2>

                    <p class="mt-1 text-xs text-zinc-500 truncate">
                        {{ $article->slug }}
                    </p>
                </div>

                <div class="flex shrink-0 flex-col items-end gap-2">
                    <span class="inline-flex items-center rounded-full border border-blue-700 bg-blue-900/30 px-2.5 py-1 text-[11px] font-medium text-blue-300">
                        {{ $article->developers_count }} autor(es)
                    </span>

                    @if($article->published_at)
                        <span class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-2.5 py-1 text-[11px] font-medium text-zinc-300">
                            {{ \Illuminate\Support\Carbon::parse($article->published_at)->format('d/m/Y') }}
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full border border-amber-700 bg-amber-900/30 px-2.5 py-1 text-[11px] font-medium text-amber-300">
                            Não publicado
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-3">
                <p class="text-sm leading-6 text-zinc-400 line-clamp-3">
                    {{ strip_tags($article->content) }}
                </p>
            </div>

            <div class="mt-3">
                <span class="mb-2 block text-[11px] font-medium uppercase tracking-wide text-zinc-500">
                    Autores
                </span>

                <div class="flex flex-wrap gap-2">
                    @forelse($article->developers->take(2) as $developer)
                        <span class="rounded-md border border-white/10 bg-white/5 px-2 py-1 text-xs text-zinc-200">
                            {{ $developer->name }}
                        </span>
                    @empty
                        <span class="text-sm text-zinc-500">
                            Sem desenvolvedores vinculados
                        </span>
                    @endforelse

                    @if($article->developers->count() > 2)
                        <span class="rounded-md border border-white/10 bg-white/5 px-2 py-1 text-xs text-zinc-400">
                            +{{ $article->developers->count() - 2 }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-4 flex items-center justify-end gap-2">
                <button
                    type="button"
                    @click="$dispatch('article::show', { id: {{ $article->id }} })"
                    class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-xl border border-white/10 bg-zinc-900 text-zinc-300 transition hover:bg-white/5 hover:text-white"
                    title="Ver artigo"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1..6" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
                @unless($article->trashed())
                    @can('update', $article)
                        <button
                            type="button"
                            @click="$dispatch('article::update', { id: {{ $article->id }} })"
                            class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-blue/10 border-blue-800 bg-blue-900/20 text-blue-300 transition hover:bg-blue-900/35"
                            title="Editar artigo"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                    @endcan

                    @can('delete', $article)
                        <button
                            type="button"
                            @click="$dispatch('article::archive', { id: {{ $article->id }} })"
                            class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-red-800 bg-red-900/20 text-red-300 transition hover:bg-red-900/35"
                            title="Excluir artigo"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.108 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    @endcan
                @else
                    @can('restore', $article)
                        <button
                            type="button"
                            @click="$dispatch('article::restore', { id: {{ $article->id }} })"
                            class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-emerald-800 bg-emerald-900/20 text-emerald-300 transition hover:bg-emerald-900/35"
                            title="Restaurar artigo"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                            </svg>
                        </button>
                    @endcan

                    @can('forceDelete', $article)
                        <button
                            type="button"
                            @click="$dispatch('article::force-delete', { id: {{ $article->id }} })"
                            class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-red-800 bg-red-900/20 text-red-300 transition hover:bg-red-900/35"
                            title="Excluir permanentemente"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.108 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    @endcan
                @endunless
            </div>
        </div>
    @empty
        <div class="rounded-2xl border border-dashed border-white/10 bg-zinc-950/60 px-6 py-12 text-center">
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
