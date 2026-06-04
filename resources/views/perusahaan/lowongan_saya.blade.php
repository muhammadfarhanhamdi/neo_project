<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lowongan Saya - NextStep</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-950 pl-60">
    <main class="min-h-screen">
        <div class="mx-auto w-full max-w-[1680px]">
            @include('perusahaan.sidebar', ['active' => 'lowongans'])

            <section class="border-l-2 border-slate-900 bg-white">
                <header class="border-b-2 border-slate-900 bg-white">
                    <div class="flex items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
                        <div class="ml-auto text-[13px] font-black uppercase tracking-[0.14em] text-slate-900">
                            {{ auth()->user()->name }}
                        </div>
                    </div>
                </header>

                <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-black uppercase">Lowongan Saya</h1>
                            <p class="mt-2 text-sm text-slate-700">Daftar lowongan yang Anda buat.</p>
                        </div>
                        <a href="{{ route('lowongan.create') }}" class="inline-flex items-center gap-2 border-4 border-slate-900 bg-[#5cf47a] px-4 py-3 text-xs font-black uppercase tracking-[0.12em] text-slate-950 shadow-[5px_5px_0_rgba(0,0,0,0.28)]">＋ Buat Lowongan</a>
                    </div>

                    <div class="mt-6 grid gap-4 lg:grid-cols-3">
                        @forelse($lowongans as $lowongan)
                            <article class="border-4 border-slate-900 bg-white p-4 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="text-lg font-black">{{ $lowongan->title }}</h3>
                                        <p class="mt-1 text-sm text-slate-600">{{ $lowongan->company }} · {{ $lowongan->location }}</p>
                                        <div class="mt-3 text-xs font-black uppercase tracking-[0.08em]">
                                            <span class="inline-block border-2 border-black bg-[#5cf47a] px-2 py-1">{{ $lowongan->type }}</span>
                                            @if($lowongan->salary_range)
                                                <span class="inline-block ml-2 border-2 border-black bg-[#f3f3f3] px-2 py-1 text-slate-700">{{ $lowongan->salary_range }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs font-black text-slate-700">{{ $lowongan->applications()->count() }} Pelamar</div>
                                        <div class="mt-3 flex flex-col gap-2">
                                            <a href="{{ route('perusahaan.lowongan.show', $lowongan->id) }}" class="inline-flex items-center justify-center border-2 border-slate-900 bg-white px-3 py-2 text-xs font-black">Lihat</a>
                                            <a href="{{ route('perusahaan.pelamar') }}?lowongan_id={{ $lowongan->id }}" class="inline-flex items-center justify-center border-2 border-slate-900 bg-[#8e36dc] px-3 py-2 text-xs font-black text-white">Pelamar</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="col-span-3 border-4 border-slate-900 bg-white p-6 text-sm font-semibold text-slate-600 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">Belum ada lowongan. Buat lowongan pertama Anda.</div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $lowongans->links() }}
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>