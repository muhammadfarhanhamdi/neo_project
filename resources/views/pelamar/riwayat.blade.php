<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Riwayat Lamaran - NextStep</title>
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
                                @if($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto profil {{ $user->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-800 to-slate-950 text-4xl font-black text-white">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-black leading-tight text-slate-950 sm:text-5xl">Riwayat Lamaran</h1>
                            <p class="mt-2 max-w-2xl text-sm text-slate-900 sm:text-base">Lihat status terakhir dan jejak perubahan setiap lamaran kamu.</p>

                            <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                                <div class="border-2 border-black bg-white px-4 py-3 shadow-[3px_3px_0_rgba(0,0,0,0.12)]">
                                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Nama</p>
                                    <p class="mt-1 truncate text-sm font-black text-slate-950">{{ $user->name }}</p>
                                </div>
                                <div class="border-2 border-black bg-white px-4 py-3 shadow-[3px_3px_0_rgba(0,0,0,0.12)]">
                                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Email</p>
                                    <p class="mt-1 truncate text-sm font-black text-slate-950">{{ $user->email }}</p>
                                </div>
                                <div class="border-2 border-black bg-white px-4 py-3 shadow-[3px_3px_0_rgba(0,0,0,0.12)]">
                                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">NIM</p>
                                    <p class="mt-1 text-sm font-black text-slate-950">{{ $user->nim ?: '-' }}</p>
                                </div>
                                <div class="border-2 border-black bg-white px-4 py-3 shadow-[3px_3px_0_rgba(0,0,0,0.12)]">
                                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Terakhir Diperbarui</p>
                                    <p class="mt-1 text-sm font-black text-slate-950">{{ $user->updated_at ? $user->updated_at->diffForHumans() : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mt-5 grid gap-5 lg:grid-cols-[260px_1fr]">
                    <aside class="space-y-4">
                        <div class="border-2 border-black bg-[#62f26f] p-4 text-center shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center overflow-hidden rounded-full border-2 border-black bg-[#d1d5db] text-3xl font-black text-slate-950">
                                @if($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto profil {{ $user->name }}" class="h-full w-full object-cover">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                            <p class="mt-3 text-sm font-black text-slate-950">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-700">Pelamar</p>
                        </div>

                        <div class="border-2 border-black bg-white p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Status Profil</p>
                            <div class="mt-2 text-3xl font-black text-[#a245ff]">{{ $profileCompleteness }}%</div>
                            <p class="mt-2 text-xs text-slate-600">Perubahan profil terbaru akan ikut terlihat di sini.</p>
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
                            <a href="{{ route('pelamar.riwayat') }}" class="flex items-center gap-3 border-2 border-black bg-[#62f26f] px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">◧</span>
                                Riwayat
                            </a>
                            <a href="{{ route('lowongan.index') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">▤</span>
                                Cari Lowongan
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
                        <section class="border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-2xl font-black text-slate-950">Riwayat Lamaran</h2>
                                    <p class="mt-1 text-xs text-slate-600">Lihat status dan riwayat perubahan setiap lamaran Anda.</p>
                                </div>
                                <div class="rounded-none border-2 border-black bg-[#f7ecff] px-4 py-3 text-right shadow-[3px_3px_0_rgba(0,0,0,0.12)]">
                                    <div class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-700">Total Halaman</div>
                                    <div class="text-2xl font-black text-[#a245ff]">{{ $applications->total() }}</div>
                                </div>
                            </div>
                        </section>

                        <div class="space-y-4">
                            @forelse($applications as $app)
                                @php
                                    $statusLabel = match ($app->status) {
                                        'submitted', 'review' => 'Proses',
                                        'accepted' => 'Diterima',
                                        'rejected' => 'Ditolak',
                                        default => ucfirst((string) $app->status),
                                    };

                                    $statusClass = match ($app->status) {
                                        'submitted', 'review' => 'bg-[#f7ecff] text-[#8a3fd6]',
                                        'accepted' => 'bg-[#62f26f] text-slate-950',
                                        'rejected' => 'bg-[#ffd6d3] text-rose-700',
                                        default => 'bg-[#f3f3f3] text-slate-700',
                                    };
                                @endphp
                                <article class="border-2 border-black bg-white p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                        <div class="flex items-start gap-4">
                                            <div class="flex h-12 w-12 items-center justify-center border-2 border-black bg-[#d9b2ff] text-sm font-black text-slate-950">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="4" y="4" width="16" height="16" rx="2" ry="2" stroke-width="1.5"/></svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-black text-slate-950">{{ optional($app->lowongan)->title ?? 'Lowongan dihapus' }}</h3>
                                                <p class="mt-1 text-sm text-slate-600">{{ optional($app->lowongan)->company ?? '-' }} · {{ $app->created_at->format('d M Y') }}</p>
                                                <div class="mt-3 inline-flex items-center border-2 border-black px-3 py-1 text-[10px] font-black uppercase tracking-[0.16em] {{ $statusClass }}">
                                                    {{ $statusLabel }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-xs font-bold text-slate-700">{{ $app->created_at->diffForHumans() }}</div>
                                    </div>

                                    <div class="mt-5 border-t-2 border-dashed border-black pt-4">
                                        <h4 class="text-sm font-black uppercase tracking-[0.16em] text-slate-800">Riwayat Status</h4>
                                        @if($app->status_history)
                                            <ol class="mt-3 space-y-3">
                                                @foreach($app->status_history as $entry)
                                                    @php
                                                        $historyLabel = match ($entry['status'] ?? '') {
                                                            'submitted', 'review' => 'Proses',
                                                            'accepted' => 'Diterima',
                                                            'rejected' => 'Ditolak',
                                                            default => ucfirst((string) ($entry['status'] ?? '')),
                                                        };
                                                    @endphp
                                                    <li class="flex items-start gap-3">
                                                        <div class="flex h-8 w-8 items-center justify-center border-2 border-black bg-[#f3f3f3] text-xs font-black text-slate-950">{{ strtoupper(substr($entry['status'], 0, 1)) }}</div>
                                                        <div>
                                                            <div class="text-sm font-bold text-slate-950">{{ $historyLabel }}</div>
                                                            <div class="text-xs text-slate-500">
                                                                {{ $entry['at'] }}
                                                                @if(!empty($entry['by']))
                                                                    · oleh {{ optional(\App\Models\User::find($entry['by']))->name ?? 'System' }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="mt-2 text-sm text-slate-500">Belum ada riwayat perubahan.</p>
                                        @endif
                                    </div>
                                </article>
                            @empty
                                <div class="border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                    Belum ada lamaran.
                                </div>
                            @endforelse
                        </div>

                        <div class="pt-2">{{ $applications->links() }}</div>
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
