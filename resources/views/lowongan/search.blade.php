<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cari Lowongan - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f3f3f3] text-slate-950">
        <main class="min-h-screen">
            <header class="border-b-2 border-black bg-white shadow-[0_2px_0_rgba(0,0,0,0.08)]">
                <div class="mx-auto flex max-w-[1680px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
                    <a href="{{ url('/') }}" class="text-2xl font-black tracking-tight text-slate-950">NextStep</a>
                    <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-900 lg:flex">
                        @guest
                            <a href="{{ url('/') }}" class="transition hover:underline">Home</a>
                            <a href="{{ route('lowongan.index') }}" class="text-[#7c3aed]">Cari Lowongan</a>
                        @else
                            <a href="{{ auth()->user()->role === 'pelamar' ? route('pelamar.dashboard') : (auth()->user()->role === 'perusahaan' ? route('perusahaan.dashboard') : route('admin.dashboard')) }}" class="transition hover:underline">Dashboard</a>
                            <a href="{{ route('lowongan.index') }}" class="text-[#7c3aed]">Cari Lowongan</a>
                            @if(auth()->user()->role === 'pelamar')
                                <a href="{{ route('pelamar.riwayat') }}" class="transition hover:underline">Riwayat</a>
                                <a href="{{ route('messages.index') }}" class="transition hover:underline">Pesan</a>
                            @endif
                        @endguest
                    </nav>
                    <div class="flex items-center gap-2">
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="rounded-[2px] border-2 border-black bg-white px-3 py-2 text-xs font-black text-slate-950 shadow-[3px_3px_0_rgba(0,0,0,0.15)] sm:px-4">Logout</button>
                            </form>
                        @else
                            <a href="{{ url('/register') }}" class="rounded-[2px] border-2 border-black bg-[#d9b2ff] px-3 py-2 text-xs font-black text-slate-950 shadow-[3px_3px_0_rgba(0,0,0,0.15)] sm:px-4">Daftar Sekarang!</a>
                        @endauth
                    </div>
                </div>
            </header>

            <div class="mx-auto w-full max-w-[1680px] px-4 py-5 sm:px-6 lg:px-10 lg:py-6">
                <section class="rounded-none border-2 border-black bg-[#62f26f] px-6 py-6 shadow-[4px_4px_0_rgba(0,0,0,0.12)] sm:px-8">
                    <div class="flex flex-col gap-3">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-900">Cari Lowongan</p>
                        <h1 class="text-3xl font-black leading-tight text-slate-950 sm:text-5xl">Temukan <span class="underline decoration-4 decoration-black underline-offset-4">Karir Impianmu</span></h1>
                        <p class="max-w-3xl text-sm text-slate-900 sm:text-base">Cari posisi yang sesuai, lihat detail dengan cepat, dan langsung lanjut ke langkah berikutnya.</p>
                    </div>
                </section>

                <section class="mt-5 grid gap-5 lg:grid-cols-[260px_1fr]">
                    <aside class="sticky top-6 h-fit space-y-4">
                        <div class="border-2 border-black bg-white p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-black uppercase tracking-[0.18em]">Filter</h3>
                                <span class="text-xs font-black">⚙</span>
                            </div>
                            <form class="mt-4 space-y-4" action="{{ route('lowongan.index') }}" method="get">
                                <div>
                                    <label class="mb-2 block text-xs font-black uppercase tracking-[0.12em] text-slate-700">Lokasi</label>
                                    <input name="location" type="text" value="{{ request('location') }}" placeholder="Kota atau Negara" class="h-10 w-full border-2 border-black bg-[#f3f3f3] px-3 text-sm outline-none" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-xs font-black uppercase tracking-[0.12em] text-slate-700">Tipe Pekerjaan</label>
                                    <div class="space-y-2 text-sm font-medium text-slate-800">
                                        <label class="flex items-center gap-2"><input name="type[]" value="Full-time" type="checkbox" class="h-4 w-4 accent-[#5cf47a]" @checked(in_array('Full-time', (array) request('type', []))) /> Full-time</label>
                                        <label class="flex items-center gap-2"><input name="type[]" value="Part-time" type="checkbox" class="h-4 w-4 accent-[#5cf47a]" @checked(in_array('Part-time', (array) request('type', []))) /> Part-time</label>
                                        <label class="flex items-center gap-2"><input name="type[]" value="Internship" type="checkbox" class="h-4 w-4 accent-[#5cf47a]" @checked(in_array('Internship', (array) request('type', []))) /> Internship</label>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-2 block text-xs font-black uppercase tracking-[0.12em] text-slate-700">Pengalaman</label>
                                    <select name="seniority" class="h-10 w-full border-2 border-black bg-[#f3f3f3] px-3 text-sm outline-none">
                                        <option value="">Semua</option>
                                        <option value="Entry" @selected(request('seniority') === 'Entry')>Entry Level</option>
                                        <option value="Mid" @selected(request('seniority') === 'Mid')>Mid Level</option>
                                        <option value="Senior" @selected(request('seniority') === 'Senior')>Senior</option>
                                    </select>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="w-full border-2 border-black bg-[#5cf47a] px-3 py-2 text-sm font-black uppercase text-slate-950">Terapkan Filter</button>
                                    <a href="{{ route('lowongan.index') }}" class="inline-flex items-center justify-center border-2 border-black bg-white px-3 py-2 text-sm font-black uppercase text-slate-950">Reset</a>
                                </div>
                            </form>
                        </div>
                    </aside>

                    <section>
                        <div class="mb-4 flex flex-col gap-3 rounded-none border-2 border-black bg-white px-4 py-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)] sm:flex-row sm:items-center sm:justify-between">
                            <form action="{{ route('lowongan.index') }}" method="get" class="flex w-full items-center border-2 border-black bg-[#f3f3f3] px-3 py-2 sm:max-w-2xl">
                                <input name="q" type="text" value="{{ request('q') }}" placeholder="Cari lowongan berdasarkan judul, perusahaan, atau lokasi" class="h-10 w-full bg-transparent text-sm outline-none" />
                                <button type="submit" class="ml-3 border-2 border-black bg-[#5cf47a] px-4 py-2 text-sm font-black">Cari</button>
                            </form>
                            <div class="text-sm font-black uppercase tracking-[0.12em] text-slate-700">{{ $lowongans->total() ?? 0 }} Lowongan Ditemukan</div>
                        </div>

                        <div class="space-y-4">
                            @foreach($lowongans as $lowongan)
                                <a href="{{ route('lowongan.show', $lowongan->id) }}" class="block">
                                    <article class="rounded-none border-2 border-black bg-white p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)] transition hover:-translate-y-0.5 hover:shadow-[6px_6px_0_rgba(0,0,0,0.14)]">
                                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                            <div class="flex items-start gap-4">
                                                <div class="flex h-14 w-14 shrink-0 items-center justify-center border-2 border-black bg-[#5cf47a] text-2xl font-black text-slate-950">{{ strtoupper(substr($lowongan->company ?? 'X', 0, 1)) }}</div>
                                                <div>
                                                    <h3 class="text-xl font-black text-slate-950">{{ $lowongan->title }}</h3>
                                                    <p class="mt-1 text-sm text-slate-600">{{ $lowongan->company }} · {{ $lowongan->location }}</p>
                                                    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs font-black uppercase tracking-[0.08em]">
                                                        <span class="border-2 border-black bg-[#5cf47a] px-2 py-1">{{ $lowongan->type }}</span>
                                                        <span class="border-2 border-black bg-[#d9b2ff] px-2 py-1 text-slate-950">{{ $lowongan->seniority }}</span>
                                                        <span class="border-2 border-black bg-[#f3f3f3] px-2 py-1 text-slate-700">{{ $lowongan->salary_range }}</span>
                                                        <span class="border-2 border-black bg-[#fde68a] px-2 py-1 text-slate-950">{{ $lowongan->applications_count ?? 0 }} Pelamar</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center justify-center border-2 border-black bg-white px-5 py-2 text-sm font-black text-slate-950">Lamar</span>
                                        </div>
                                    </article>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6 rounded-none border-2 border-black bg-white px-4 py-3 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            {{ $lowongans->links() }}
                        </div>
                    </section>
                </section>
            </div>
        </main>
    </body>
</html>
