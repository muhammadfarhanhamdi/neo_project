@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f3f3f3]">

    <!-- Navbar -->
    <nav class="border-b-4 border-black bg-white">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-wrap justify-between items-center gap-4">

            <div class="text-2xl font-black">
                NextStep
            </div>

            <div class="hidden md:flex gap-8 font-semibold text-sm">
                @guest
                    <a href="{{ url('/') }}" class="transition hover:text-purple-600">Home</a>
                    <a href="{{ route('lowongan.index') }}" class="transition hover:text-purple-600">Cari Lowongan</a>
                @else
                    <a href="{{ auth()->user()->role === 'pelamar' ? route('pelamar.dashboard') : (auth()->user()->role === 'perusahaan' ? route('perusahaan.dashboard') : route('admin.dashboard')) }}" class="transition hover:text-purple-600">Dashboard</a>
                    <a href="{{ route('lowongan.index') }}" class="transition hover:text-purple-600">Cari Lowongan</a>
                    @if(auth()->user()->role === 'pelamar')
                        <a href="{{ route('pelamar.riwayat') }}" class="transition hover:text-purple-600">Riwayat</a>
                        <a href="{{ route('messages.index') }}" class="transition hover:text-purple-600">Pesan</a>
                    @endif
                @endguest
            </div>

            <div class="flex gap-3">
                @guest
                    <a href="{{ route('login') }}" class="px-5 py-2 border-2 border-black font-bold hover:bg-black hover:text-white transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-purple-600 text-white border-2 border-black font-bold shadow-[4px_4px_0px_#000]">Daftar Sekarang</a>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-5 py-2 border-2 border-black font-bold hover:bg-black hover:text-white transition">Logout</button>
                    </form>
                @endguest
            </div>

        </div>
    </nav>

    <!-- Hero -->
    <section class="max-w-7xl mx-auto px-6 py-12">

        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <!-- Left -->
            <div class="rounded-[32px] border-4 border-black bg-white p-10 shadow-[8px_8px_0_rgba(0,0,0,0.12)]">

                <div class="inline-flex items-center rounded-full bg-[#62f26f] px-4 py-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-950 shadow-[0_4px_0_rgba(0,0,0,0.12)]">
                    Selamat Datang
                </div>

                <h1 class="mt-8 text-6xl font-black leading-tight uppercase text-slate-950">
                    Temukan Pekerjaan
                    Impianmu
                </h1>

                <p class="mt-5 text-slate-700 max-w-lg">
                    Kami membantu Anda menemukan pekerjaan dengan lebih mudah.
                    Ribuan lowongan aktif menunggu keahlian terbaik Anda.
                </p>

                <form action="{{ route('lowongan.index') }}" method="get" class="mt-8">
                    <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                        <input
                            name="keyword"
                            type="text"
                            placeholder="Contoh: UI Designer, Frontend Developer..."
                            class="w-full h-14 rounded-[24px] border-4 border-black bg-[#f3f3f3] px-5 text-slate-950 outline-none transition focus:border-[#7c3aed] focus:bg-white" />

                        <button
                            type="submit"
                            class="w-full h-14 rounded-[24px] bg-[#62f26f] border-4 border-black font-black uppercase text-slate-950 shadow-[5px_5px_0px_#000] transition hover:bg-[#16a34a] sm:w-auto">
                            CARI
                        </button>
                    </div>
                </form>

                <div class="flex flex-wrap gap-3 mt-6">
                    <span class="px-4 py-1 bg-[#d9b2ff] border-4 border-black text-xs font-black uppercase text-slate-950">
                        Remote
                    </span>
                    <span class="px-4 py-1 bg-[#ecfdf5] border-4 border-black text-xs font-black uppercase text-slate-950">
                        Fulltime
                    </span>
                    <span class="px-4 py-1 bg-[#f3e8ff] border-4 border-black text-xs font-black uppercase text-slate-950">
                        Freelance
                    </span>
                </div>

            </div>

            <!-- Right -->
            <div class="relative flex justify-center">

                <div
                    class="w-72 h-72 bg-white border-4 border-black rotate-3 shadow-[8px_8px_0px_#000] flex items-center justify-center">

                    <img src="{{ asset('images/logo.svg') }}"
                        class="w-40"
                        alt="NextStep logo">

                </div>

                <div
                    class="absolute bottom-10 left-10 bg-[#62f26f] border-4 border-black px-5 py-2 font-black uppercase tracking-[0.12em] -rotate-6 shadow-[4px_4px_0px_#000] text-slate-950">

                    AYO MULAI →
                </div>

            </div>

        </div>

        <!-- Cards -->
        <div class="grid lg:grid-cols-3 gap-6 mt-12">

            <!-- Logo strip -->
            <div class="lg:col-span-3 bg-white border-4 border-black p-6 shadow-[8px_8px_0px_#000]">
                <p class="text-xs uppercase tracking-[0.28em] text-slate-700">Trusted by</p>
                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4 items-center">
                    <img src="{{ asset('images/company-logo-1.svg') }}" alt="Logo 1" class="w-full rounded-[18px] border-2 border-slate-900 bg-white p-3" />
                    <img src="{{ asset('images/company-logo-2.svg') }}" alt="Logo 2" class="w-full rounded-[18px] border-2 border-slate-900 bg-white p-3" />
                    <img src="{{ asset('images/company-logo-3.svg') }}" alt="Logo 3" class="w-full rounded-[18px] border-2 border-slate-900 bg-white p-3" />
                    <img src="{{ asset('images/company-logo-4.svg') }}" alt="Logo 4" class="w-full rounded-[18px] border-2 border-slate-900 bg-white p-3" />
                </div>
            </div>

            <!-- Card 1 -->
            <div
                class="lg:col-span-2 bg-[#d9b2ff] border-4 border-black p-8 shadow-[8px_8px_0px_#000]">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-xs uppercase mb-2 text-slate-950">
                            Fitur Unggulan
                        </p>

                        <h2 class="text-4xl font-black text-slate-950">
                            Matching AI Super Cepat
                        </h2>

                        <p class="mt-4 text-slate-700">
                            Teknologi kami memetakan skill Anda dengan
                            kebutuhan industri secara real-time.
                        </p>
                    </div>

                    <div
                        class="w-16 h-16 bg-white border-4 border-black flex items-center justify-center font-black text-2xl">
                        ⚡
                    </div>

                </div>

            </div>

            <!-- Card 2 -->
            <div
                class="bg-white border-4 border-black p-8 shadow-[8px_8px_0px_#000]">

                <div
                    class="w-16 h-16 rounded-full bg-[#62f26f] border-4 border-black flex items-center justify-center text-2xl text-slate-950">
                    🔒
                </div>

                <h3 class="font-black text-3xl mt-5 text-slate-950">
                    500+
                </h3>

                <p class="text-slate-700">
                    Perusahaan Telah Bergabung
                </p>

            </div>

        </div>

        <!-- Bottom -->
        <div class="grid lg:grid-cols-3 gap-6 mt-6">

            <!-- Notification -->
            <div
                class="bg-[#62f26f] border-4 border-black p-8 shadow-[8px_8px_0px_#000]">

                <h3 class="text-2xl font-black text-slate-950">
                    Notifikasi Instan
                </h3>

                <p class="mt-3 text-slate-950">
                    Dapatkan kabar lowongan terbaru melalui email dan WhatsApp.
                </p>

                <div class="mt-10 h-2 bg-white border-4 border-black">
                    <div class="w-2/3 h-full bg-black"></div>
                </div>

            </div>

            <!-- Jobs -->
            <div
                class="lg:col-span-2 bg-white border-4 border-black p-8 shadow-[8px_8px_0px_#000]">

                <h2 class="text-3xl font-black mb-6 text-slate-950">
                    Lowongan Terbaru
                </h2>

                <div class="space-y-5">
                    @forelse($latestLowongans as $lowongan)
                        <div class="flex flex-col gap-4 border-b-2 border-black pb-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex gap-4">
                                <div class="w-10 h-10 bg-purple-600 text-white flex items-center justify-center font-black">
                                    {{ strtoupper(substr($lowongan->company ?? 'X', 0, 1)) }}
                                </div>

                                <div>
                                    <h4 class="font-bold">
                                        {{ $lowongan->title }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $lowongan->company }} · {{ $lowongan->location ?? 'Remote' }} · {{ $lowongan->salary_range }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="rounded-full border-2 border-black bg-[#fde68a] px-3 py-1 text-[11px] font-black uppercase tracking-[0.18em] text-slate-950">
                                    {{ $lowongan->applications_count ?? 0 }} Pelamar
                                </span>
                                <span>→</span>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-none border-2 border-black bg-[#f8f8f8] p-6 text-center text-sm font-semibold text-slate-700">
                            Belum ada lowongan terbaru saat ini.
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('lowongan.index') }}" class="inline-flex items-center justify-center rounded-none border-4 border-black bg-white px-8 py-3 font-black uppercase text-slate-950 transition hover:bg-black hover:text-white">
                        Lihat Semua Lowongan
                    </a>
                </div>

            </div>

        </div>

    </section>

    <!-- Footer -->
    <footer class="bg-black text-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between">

            <div class="font-black">
                NextStep
            </div>

            <div class="text-sm text-gray-400">
                © 2025 NextStep
            </div>

        </div>
    </footer>

</div>
@endsection