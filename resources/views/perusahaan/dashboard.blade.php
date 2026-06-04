<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard Perusahaan - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-slate-950 pl-60">
        <main class="min-h-screen">
            <div class="mx-auto w-full max-w-[1680px]">
                @include('perusahaan.sidebar', ['active' => 'dashboard'])

                <section class="border-l-2 border-slate-900 bg-white">
                    <header class="border-b-2 border-slate-900 bg-white">
                        <div class="flex items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
                            <div class="ml-auto text-[13px] font-black uppercase tracking-[0.14em] text-slate-900">
                                {{ auth()->user()->name }}
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="border-2 border-slate-900 bg-[#ffd6d3] px-3 py-2 text-[11px] font-black uppercase tracking-[0.18em] text-rose-700">Logout</button>
                            </form>
                        </div>
                    </header>

                    <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                            <div class="max-w-4xl">
                                <h1 class="text-4xl font-black uppercase leading-[0.92] sm:text-5xl">Dashboard<br>Perusahaan</h1>
                                <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-700 sm:text-base">Selamat datang kembali, {{ auth()->user()->name }}. Berikut adalah ringkasan performa rekrutmen perusahaan Anda untuk minggu ini.</p>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row">
                                <a href="{{ route('messages.index') }}" class="inline-flex min-w-[176px] items-center justify-center gap-2 border-4 border-slate-900 bg-[#8e36dc] px-5 py-4 text-xs font-black uppercase tracking-[0.18em] text-white shadow-[5px_5px_0_rgba(0,0,0,0.28)]">
                                    <span class="text-base">▶</span>
                                    Kirim Pesan Massal
                                </a>
                                <a href="{{ route('lowongan.create') }}" class="inline-flex min-w-[176px] items-center justify-center gap-2 border-4 border-slate-900 bg-[#5cf47a] px-5 py-4 text-xs font-black uppercase tracking-[0.18em] text-slate-950 shadow-[5px_5px_0_rgba(0,0,0,0.28)]">
                                    <span class="text-base">＋</span>
                                    Buat Lowongan
                                </a>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="mt-5 border-2 border-green-900 bg-green-100 px-4 py-3 text-sm font-semibold text-green-800">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mt-7 grid gap-4 lg:grid-cols-3">
                            <article class="border-4 border-slate-900 bg-[#ebd7ff] p-5 shadow-[6px_6px_0_rgba(0,0,0,0.28)]">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center border-2 border-slate-900 bg-white text-sm">👜</div>
                                    <span class="border-2 border-slate-900 bg-white px-2 py-1 text-[10px] font-black uppercase tracking-[0.16em]">Aktif</span>
                                </div>
                                <p class="mt-6 text-5xl font-black leading-none">{{ $stats['total_lowongan'] }}</p>
                                <p class="mt-2 text-xs font-black uppercase tracking-[0.24em] text-slate-800">Lowongan Aktif</p>
                            </article>

                            <article class="border-4 border-slate-900 bg-[#61f275] p-5 shadow-[6px_6px_0_rgba(0,0,0,0.28)]">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center border-2 border-slate-900 bg-white text-sm">👥</div>
                                    <span class="border-2 border-slate-900 bg-white px-2 py-1 text-[10px] font-black uppercase tracking-[0.16em]">+1% Baru</span>
                                </div>
                                <p class="mt-6 text-5xl font-black leading-none">{{ $stats['total_pelamar'] }}</p>
                                <p class="mt-2 text-xs font-black uppercase tracking-[0.24em] text-slate-800">Total Pelamar</p>
                            </article>

                            <article class="border-4 border-slate-900 bg-black p-5 text-white shadow-[6px_6px_0_rgba(0,0,0,0.28)]">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center border-2 border-[#5cf47a] bg-black text-sm text-[#5cf47a]">🗓</div>
                                    <span class="border-2 border-[#b57dff] bg-black px-2 py-1 text-[10px] font-black uppercase tracking-[0.16em] text-[#b57dff]">Hari ini</span>
                                </div>
                                <p class="mt-6 text-5xl font-black leading-none text-[#5cf47a]">{{ $stats['scheduled_applications'] }}</p>
                                <p class="mt-2 text-xs font-black uppercase tracking-[0.24em] text-white/80">Mendaftar Terjadwal</p>
                            </article>
                        </div>

                        <div class="mt-8 grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                            <div id="lowongan-terbaru">
                                <div class="mb-3 flex items-end justify-between border-b-4 border-slate-900 pb-2">
                                    <h2 class="text-2xl font-black uppercase">Lowongan Terbaru</h2>
                                    <a href="{{ route('lowongan.index') }}" class="text-[11px] font-black uppercase tracking-[0.2em] text-[#8e36dc]">Lihat Semua</a>
                                </div>

                                <div class="space-y-4">
                                    @forelse ($dashboardLowongans as $index => $lowongan)
                                        <article class="flex items-center gap-4 border-4 border-slate-900 bg-white p-4 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                            <div class="flex h-14 w-14 shrink-0 items-center justify-center border-4 border-slate-900 bg-[#ead8ff] text-lg">
                                                @if ($index === 0)
                                                    ✎
                                                @elseif ($index === 1)
                                                    ⇱
                                                @else
                                                    ☰
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="flex flex-wrap items-start justify-between gap-2">
                                                    <div>
                                                        <h3 class="text-lg font-black leading-tight text-slate-950">{{ $lowongan->title }}</h3>
                                                        <div class="mt-2 flex flex-wrap gap-2 text-[10px] font-black uppercase tracking-[0.16em]">
                                                            @if ($lowongan->type)
                                                                <span class="border border-slate-900 bg-[#e6f7e8] px-2 py-1">{{ $lowongan->type }}</span>
                                                            @endif
                                                            @if ($lowongan->seniority)
                                                                <span class="border border-slate-900 bg-[#f1e1ff] px-2 py-1">{{ $lowongan->seniority }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="text-right text-[11px] font-black uppercase tracking-[0.18em] text-slate-700">
                                                        <p>{{ $lowongan->applications_count }} Pelamar</p>
                                                        <p class="mt-1 text-slate-950">{{ $lowongan->salary_range ?: 'Rp --' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    @empty
                                        <div class="border-4 border-slate-900 bg-white p-5 text-sm font-semibold text-slate-600 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">Belum ada lowongan.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div id="pelamar-baru">
                                <div class="mb-3 flex items-end justify-between border-b-4 border-slate-900 pb-2">
                                    <h2 class="text-2xl font-black uppercase">Pelamar Baru</h2>
                                </div>

                                <div class="space-y-3 border-4 border-slate-900 bg-white p-3 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                    @forelse ($dashboardApplications as $application)
                                        <article class="flex items-center gap-3 border-4 border-slate-900 bg-[#efefef] p-2">
                                            @if (optional($application->user)->profile_photo_path)
                                                <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}" alt="{{ $application->name }}" class="h-11 w-11 border-2 border-slate-900 object-cover" />
                                            @else
                                                <div class="flex h-11 w-11 items-center justify-center border-2 border-slate-900 bg-white text-xs font-black">
                                                    {{ strtoupper(substr($application->name, 0, 2)) }}
                                                </div>
                                            @endif

                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-black leading-tight">{{ $application->name }}</p>
                                                <p class="truncate text-[11px] font-semibold text-slate-600">{{ optional($application->lowongan)->title ?: 'Lowongan dihapus' }}</p>
                                                <p class="truncate text-[10px] font-black uppercase tracking-[0.16em] text-[#8e36dc]">{{ $application->email }}</p>
                                            </div>

                                            <div class="h-6 w-6 border-2 border-slate-900 bg-white"></div>
                                        </article>
                                    @empty
                                        <div class="border-4 border-slate-900 bg-white p-4 text-sm font-semibold text-slate-600">Belum ada pelamar baru.</div>
                                    @endforelse

                                    <a href="{{ route('perusahaan.pelamar') }}" class="block border-4 border-slate-900 bg-[#efefef] px-3 py-3 text-center text-[11px] font-black uppercase tracking-[0.2em]">Lihat Semua Pelamar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
