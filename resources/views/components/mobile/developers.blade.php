<div class="md:hidden">
    @forelse($developers as $developer)
        <div class="border-b border-white/10 py-4 last:border-b-0">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <h2 class="text-base font-semibold leading-tight text-white break-words">
                                {{ $developer->name }}
                            </h2>

                            <p class="mt-1 text-sm text-zinc-400 whitespace-nowrap">
                                {{ $developer->email }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium
                            {{ $seniorityColors[strtolower($developer->seniority)] ?? 'border border-zinc-700 bg-zinc-800 text-zinc-200' }}">
                            {{ \App\Enums\Seniority::from($developer->seniority)->label() }}
                        </span>

                        <span class="inline-flex items-center rounded-full border border-blue-700 bg-blue-900/30 px-2.5 py-1 text-xs font-medium text-blue-300">
                            {{ $developer->articles_count ?? $developer->articles->count() }} artigo(s)
                        </span>
                    </div>

                    <div class="mt-3">
                        <span class="mb-2 block text-[11px] font-medium uppercase tracking-wide text-zinc-500">
                            Skills
                        </span>

                        <div class="flex flex-wrap gap-2">
                            @forelse($developer->skills as $skill)
                                <span class="rounded-md border border-white/10 bg-white/5 px-2 py-1 text-xs text-zinc-200">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <span class="text-sm text-zinc-500">
                                    Sem skills cadastradas
                                </span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="flex shrink-0 flex-col gap-2">
                    @unless($developer->trashed())
                        @can('update', $developer)
                            <button
                                type="button"
                                @click="$dispatch('developer::update', { id: {{ $developer->id }} })"
                                class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-white/10 bg-zinc-900 text-zinc-300 transition hover:bg-white/5 hover:text-white"
                                title="Editar desenvolvedor"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </button>
                        @endcan

                        @can('delete', $developer)
                            <button
                                type="button"
                                @click="$dispatch('developer::archive', { id: {{ $developer->id }} })"
                                class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-red-800 bg-red-900/20 text-red-300 transition hover:bg-red-900/35"
                                title="Arquivar desenvolvedor"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.108 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        @endcan
                    @else
                        @can('restore', $developer)
                            <button
                                type="button"
                                @click="$dispatch('developer::restore', { id: {{ $developer->id }} })"
                                class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-emerald-800 bg-emerald-900/20 text-emerald-300 transition hover:bg-emerald-900/35"
                                title="Restaurar desenvolvedor"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                </svg>
                            </button>
                        @endcan

                        @can('forceDelete', $developer)
                            <button
                                type="button"
                                @click="$dispatch('developer::force-delete', { id: {{ $developer->id }} })"
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
        </div>
    @empty
        <div class="rounded-2xl border border-dashed border-white/10 bg-zinc-950/60 px-6 py-12 text-center">
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
