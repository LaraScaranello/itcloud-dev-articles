<div>
    @if($modal && $article)
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
                <div class="relative z-10 my-4 w-full max-w-4xl rounded-2xl border border-white/10 bg-zinc-950 shadow-2xl sm:my-8">
                    <div class="border-b border-white/10 px-6 py-5 sm:px-8">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-white">
                                    Visualizar artigo
                                </h2>
                            </div>

                            <button
                                type="button"
                                wire:click="$set('modal', false)"
                                class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-white/10 text-zinc-400 transition hover:bg-white/5 hover:text-white"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="px-6 py-6 sm:px-8">
                        @if($article->cover_image)
                            @php
                                $cover = str_starts_with($article->cover_image, 'http')
                                    ? $article->cover_image
                                    : Storage::url($article->cover_image);
                            @endphp

                            <div class="mb-6 overflow-hidden rounded-2xl border border-white/10 bg-zinc-900">
                                <img
                                    src="{{ $cover }}"
                                    alt="{{ $article->title }}"
                                    class="h-56 w-full object-cover sm:h-72"
                                >
                            </div>
                        @endif

                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center rounded-full border border-blue-700 bg-blue-900/30 px-3 py-1 text-xs font-medium text-blue-300">
                                {{ $article->developers->count() }} autor(es)
                            </span>

                            @if($article->published_at)
                                <span class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-zinc-300">
                                    {{ \Illuminate\Support\Carbon::parse($article->published_at)->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>

                        <div class="mt-5">
                            <h1 class="text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                                {{ $article->title }}
                            </h1>

                            <p class="mt-2 text-sm text-zinc-500">
                                {{ $article->slug }}
                            </p>
                        </div>

                        <div class="mt-6">
                            <span class="mb-3 block text-xs font-medium uppercase tracking-wide text-zinc-500">
                                Autores
                            </span>

                            <div class="flex flex-wrap gap-2">
                                @forelse($article->developers as $developer)
                                    <span class="rounded-lg border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-zinc-200">
                                        {{ $developer->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-zinc-500">
                                        Nenhum autor vinculado
                                    </span>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-8 rounded-2xl border border-white/10 bg-zinc-900/50 p-5">
                            <div class="prose prose-invert max-w-none prose-headings:text-white prose-p:text-zinc-300 prose-strong:text-white prose-li:text-zinc-300">
                                {!! $article->content !!}
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end border-t border-white/10 pt-5">
                            <button
                                type="button"
                                wire:click="$set('modal', false)"
                                class="inline-flex cursor-pointer items-center justify-center rounded-xl border border-white/10 px-4 py-2.5 text-sm font-medium text-zinc-300 transition hover:bg-white/5 hover:text-white"
                            >
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
