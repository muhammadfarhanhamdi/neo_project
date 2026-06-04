<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard Pelamar - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f3f3f3] text-slate-950">
        @php
            $chartValues = [68, 86, 74, 100, 91, 95, 100];
            $chartLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
            $recentApplications = $myApplications->take(2);
            $recentLowongans = $latestLowongans->take(2);
        @endphp

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
                                <div class="absolute bottom-1 right-1 flex h-7 w-7 items-center justify-center rounded-full border-2 border-black bg-[#55e36d] text-[11px] font-black text-slate-950">✎</div>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-black leading-tight text-slate-950 sm:text-5xl">Halo, {{ auth()->user()->name }}!</h1>
                            <p class="mt-2 max-w-2xl text-sm text-slate-900 sm:text-base">Selamat datang kembali di pusat kendali karirmu.</p>
                        </div>
                    </div>
                </section>

                <section class="mt-4 grid gap-5 lg:grid-cols-[260px_1fr]">
                    <aside class="space-y-4">
                        <div class="rounded-none border-2 border-black bg-[#62f26f] p-4 text-center shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center overflow-hidden rounded-full border-2 border-black bg-[#d1d5db] text-3xl font-black text-slate-950">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Foto profil {{ auth()->user()->name }}" class="h-full w-full object-cover">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <p class="mt-3 text-sm font-black">{{ auth()->user()->name }}</p>
                        </div>

                        <nav class="space-y-3">
                            <a href="{{ route('pelamar.dashboard') }}" class="flex items-center gap-3 border-2 border-black bg-[#62f26f] px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">▣</span>
                                Dashboard
                            </a>
                            <a href="{{ route('pelamar.profile.edit') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">◫</span>
                                Profil
                            </a>
                            <a href="{{ route('pelamar.riwayat') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">◧</span>
                                Aplikasi Saya
                            </a>
                            <a href="{{ route('pelamar.saved') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">▤</span>
                                Simpan
                            </a>
                            <a href="{{ route('messages.index') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">✉</span>
                                Pesan
                            </a>
                        </nav>

                        <div class="border-t-2 border-black"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full border-2 border-black bg-[#ffd6d3] px-4 py-3 text-left text-sm font-semibold text-rose-700 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Keluar</button>
                        </form>

                        <div class="border-2 border-black bg-[#dec8ff] p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <p class="text-sm font-black text-slate-950">Upgrade Pro</p>
                            <p class="mt-2 text-xs text-slate-700">Dapatkan akses eksklusif ke lowongan prioritas.</p>
                            <a href="{{ route('lowongan.index') }}" class="mt-4 block w-full border-2 border-black bg-black px-4 py-3 text-center text-xs font-black text-white">PELAJARI</a>
                        </div>
                    </aside>

                    <div class="space-y-5">
                        <section class="border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-2xl font-black text-slate-950">Jumlah Penayangan Profil</h2>
                                    <p class="mt-1 text-xs text-slate-600">Statistik 7 hari terakhir</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-4xl font-black text-[#a245ff]">1,284</div>
                                    <div class="text-xs font-semibold text-emerald-500">+12% minggu ini</div>
                                </div>
                            </div>

                            <div class="mt-4 grid gap-3 border-2 border-black bg-[#f7ecff] p-4 sm:grid-cols-[1fr_180px] sm:items-center">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-700">Kelengkapan Profil</p>
                                    <p class="mt-1 text-sm text-slate-700">Profil Anda sudah terisi {{ $profileCompleteness }}%.</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-black text-[#a245ff]">{{ $profileCompleteness }}%</div>
                                    <div class="mt-2 h-3 overflow-hidden border-2 border-black bg-white">
                                        <div class="h-full bg-[#52df66]" style="width: {{ $profileCompleteness }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 grid h-44 grid-cols-7 items-end gap-3">
                                @foreach($chartValues as $index => $value)
                                    <div class="flex h-full flex-col items-center justify-end gap-2">
                                        <div class="w-full rounded-none border-2 border-black {{ $index === 3 ? 'bg-[#a245ff]' : ($index === 6 ? 'bg-[#52df66]' : 'bg-[#d8d8d8]') }}" style="height: {{ $value }}%"></div>
                                        <div class="text-[10px] font-bold text-slate-900">{{ $chartLabels[$index] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="grid gap-5 lg:grid-cols-2">
                            <div>
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="text-lg font-black text-slate-950">Terakhir Dilamar</h3>
                                    <a href="{{ route('pelamar.riwayat') }}" class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-700">LIHAT SEMUA</a>
                                </div>

                                <div class="space-y-4">
                                    @forelse($recentApplications as $application)
                                        <article class="border-2 border-black bg-white p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                            <div class="flex items-start gap-4">
                                                <div class="flex h-11 w-11 items-center justify-center border-2 border-black bg-[#d9b2ff] text-sm font-black text-slate-950">▣</div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-black text-slate-950">{{ optional($application->lowongan)->title ?: 'Lowongan dihapus' }}</p>
                                                    <p class="mt-1 text-xs text-slate-600">{{ optional($application->lowongan)->company ?: '-' }}</p>
                                                    <div class="mt-3 inline-block border-2 border-black bg-[#62f26f] px-2 py-1 text-[10px] font-black uppercase text-slate-950">{{ $application->status }}</div>
                                                </div>
                                                <div class="text-[10px] font-semibold text-slate-700">{{ $application->created_at->diffForHumans() }}</div>
                                            </div>
                                        </article>
                                    @empty
                                        <div class="border-2 border-black bg-white p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Belum ada lamaran.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="text-lg font-black text-slate-950">Terakhir Dilihat</h3>
                                    <a href="{{ route('lowongan.index') }}" class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-700">LIHAT SEMUA</a>
                                </div>

                                <div class="space-y-4">
                                    @forelse($recentLowongans as $lowongan)
                                        <article class="border-2 border-black bg-white p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                            <div class="flex items-start gap-4">
                                                <div class="flex h-11 w-11 items-center justify-center border-2 border-black bg-[#62f26f] text-sm font-black text-slate-950">◉</div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-black text-slate-950">{{ $lowongan->title }}</p>
                                                    <p class="mt-1 text-xs text-slate-600">{{ $lowongan->company }}</p>
                                                    <div class="mt-3 flex flex-wrap gap-2 text-[10px] font-black uppercase">
                                                        <span class="border-2 border-black bg-[#ffd7df] px-2 py-1 text-rose-700">REMOTE</span>
                                                        <span class="border-2 border-black bg-[#d9b2ff] px-2 py-1 text-slate-950">FULL-TIME</span>
                                                    </div>
                                                </div>
                                                <div class="text-[10px] font-semibold text-slate-700">{{ $lowongan->created_at->diffForHumans() }}</div>
                                            </div>
                                        </article>
                                    @empty
                                        <div class="border-2 border-black bg-white p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Belum ada lowongan terbaru.</div>
                                    @endforelse
                                </div>
                            </div>
                        </section>
                    </div>
                </section>
            </div>

            <footer class="mt-10 border-t-4 border-black bg-black text-white">
                <div class="mx-auto flex max-w-[1680px] flex-col gap-2 px-4 py-6 text-xs sm:px-6 sm:flex-row sm:items-center sm:justify-between lg:px-10">
                    <div>
                        <p class="text-2xl font-black tracking-tight">NextStep</p>
                        <p class="mt-1 text-white/70">© 2024 NextStep. Bangun Karirmu Sekarang.</p>
                    </div>
                    <div class="flex flex-wrap gap-4 text-white/70">
                        <a href="{{ url('/#fitur') }}">Tentang Kami</a>
                        <a href="{{ route('help.password') }}">Pusat Bantuan</a>
                        <a href="{{ url('/#perusahaan') }}">Kebijakan Privasi</a>
                        <a href="{{ url('/#alur') }}">Syarat & Ketentuan</a>
                    </div>
                </div>
            </footer>
        </main>
    </body>
</html>
