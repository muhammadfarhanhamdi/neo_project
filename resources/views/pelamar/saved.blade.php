<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lowongan Disimpan - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f3f3f3] text-slate-950">
        <main class="min-h-screen">
            <header class="border-b-2 border-black bg-white shadow-[0_2px_0_rgba(0,0,0,0.08)]">
                <div class="mx-auto flex max-w-[1680px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
                    <a href="{{ url('/') }}" class="text-2xl font-black tracking-tight text-slate-950">NextStep</a>
                    <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-900 lg:flex">
                        @auth
                            <a href="{{ route('pelamar.dashboard') }}" class="transition hover:underline">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="transition hover:underline">Dashboard</a>
                        @endauth
                        <a href="{{ url('/lowongan') }}" class="transition hover:underline">Cari Lowongan</a>
                        @auth
                            <a href="{{ auth()->user()->role === 'pelamar' ? route('pelamar.riwayat') : route('perusahaan.dashboard') }}" class="transition hover:underline">Riwayat</a>
                        @else
                            <a href="{{ route('login') }}" class="transition hover:underline">Riwayat</a>
                        @endauth
                        @auth
                            <a href="{{ route('messages.index') }}" class="transition hover:underline">Pesan</a>
                        @else
                            <a href="{{ route('login') }}" class="transition hover:underline">Pesan</a>
                        @endauth
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
                    <div class="grid items-center gap-5 lg:grid-cols-[128px_1fr]">
                        <div class="flex items-center justify-center">
                            <div class="relative h-24 w-24 overflow-hidden rounded-full border-2 border-black bg-[#d1d5db] shadow-[3px_3px_0_rgba(0,0,0,0.12)] sm:h-28 sm:w-28">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Foto profil {{ auth()->user()->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-800 to-slate-950 text-4xl font-black text-white">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-black leading-tight text-slate-950 sm:text-5xl">Lowongan Disimpan</h1>
                            <p class="mt-2 max-w-2xl text-sm text-slate-900 sm:text-base">Lihat kembali lowongan yang sudah kamu simpan untuk dilamar nanti.</p>
                        </div>
                    </div>
                </section>

                <section class="mt-5 grid gap-5 lg:grid-cols-[260px_1fr]">
                    <aside class="space-y-4">
                        <div class="border-2 border-black bg-[#62f26f] p-4 text-center shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center overflow-hidden rounded-full border-2 border-black bg-[#d1d5db] text-3xl font-black text-slate-950">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Foto profil {{ auth()->user()->name }}" class="h-full w-full object-cover">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <p class="mt-3 text-sm font-black text-slate-950">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-700">Pelamar</p>
                        </div>

                        <nav class="space-y-3">
                            <a href="{{ route('pelamar.dashboard') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">▣</span>
                                Dashboard
                            </a>
                            <a href="{{ route('pelamar.profile.edit') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">◫</span>
                                Profil
                            </a>
                            <a href="{{ route('pelamar.riwayat') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">◧</span>
                                Riwayat
                            </a>
                            <a href="{{ route('pelamar.saved') }}" class="flex items-center gap-3 border-2 border-black bg-[#62f26f] px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">▤</span>
                                Simpan
                            </a>
                            <a href="{{ route('messages.index') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">✉</span>
                                Pesan
                            </a>
                        </nav>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full border-2 border-black bg-[#ffd6d3] px-4 py-3 text-left text-sm font-semibold text-rose-700 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Keluar</button>
                        </form>
                    </aside>

                    <div class="space-y-5">
                        @if(session('success'))
                            <div class="rounded-none border-2 border-green-900 bg-green-100 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
                        @endif

                        @if($savedLowongans->isEmpty())
                            <div class="rounded-none border-2 border-black bg-white p-6 text-sm text-slate-700 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <p class="font-black uppercase tracking-[0.22em] text-slate-900">Tidak ada lowongan tersimpan.</p>
                                <p class="mt-3 text-sm text-slate-700">Simpan lowongan menarik agar kamu bisa kembali nanti.</p>
                                <a href="{{ route('lowongan.index') }}" class="mt-4 inline-flex items-center gap-2 border-2 border-black bg-[#5cf47a] px-4 py-3 text-sm font-black uppercase tracking-[0.16em] text-slate-950">Cari Lowongan</a>
                            </div>
                        @else
                            <div class="grid gap-5">
                                @foreach($savedLowongans as $lowongan)
                                    <article class="overflow-hidden rounded-none border-2 border-black bg-white shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                        <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-start sm:justify-between sm:p-6">
                                            <div class="space-y-3">
                                                <div class="flex flex-wrap items-center gap-2 text-[10px] font-black uppercase tracking-[0.22em] text-slate-500">
                                                    <span>{{ $lowongan->company }}</span>
                                                    <span>•</span>
                                                    <span>{{ $lowongan->location ?: 'Lokasi fleksibel' }}</span>
                                                </div>
                                                <h2 class="text-2xl font-black uppercase tracking-[-0.03em] text-slate-950">{{ $lowongan->title }}</h2>
                                                <div class="flex flex-wrap gap-2 text-sm text-slate-700">
                                                    <span class="rounded border border-slate-900 px-3 py-2 uppercase tracking-[0.14em]">{{ $lowongan->type ?: 'Full-time' }}</span>
                                                    <span class="rounded border border-slate-900 px-3 py-2 uppercase tracking-[0.14em]">{{ $lowongan->seniority ?: 'Mid' }}</span>
                                                    <span class="rounded border border-slate-900 px-3 py-2 uppercase tracking-[0.14em]">{{ $lowongan->applications_count ?? 0 }} Pelamar</span>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap gap-3">
                                                <a href="{{ route('lowongan.show', $lowongan->id) }}" class="inline-flex items-center justify-center border-2 border-black bg-[#62f26f] px-4 py-3 text-sm font-black uppercase tracking-[0.16em] text-slate-950">Detail</a>
                                                <form action="{{ route('lowongan.unsave', $lowongan->id) }}" method="post" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center justify-center border-2 border-black bg-white px-4 py-3 text-sm font-black uppercase tracking-[0.16em] text-slate-950">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                {{ $savedLowongans->links() }}
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
