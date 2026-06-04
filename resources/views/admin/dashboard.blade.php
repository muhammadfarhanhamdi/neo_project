<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - NextStep</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f3f3] text-slate-950">
    <main class="min-h-screen">
        <header class="border-b-2 border-black bg-white">
            <div class="mx-auto flex max-w-[1680px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
                <a href="{{ url('/') }}" class="text-2xl font-black tracking-tight text-slate-950">NextStep</a>
                <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-900 lg:flex">
                    <a href="{{ route('admin.dashboard') }}" class="transition hover:underline">Dashboard</a>
                    <a href="{{ route('admin.alumni.index') }}" class="transition hover:underline">Manajemen Alumni</a>
                </nav>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-[2px] border-2 border-black bg-white px-3 py-2 text-xs font-black text-slate-950 shadow-[3px_3px_0_rgba(0,0,0,0.15)] sm:px-4">Logout</button>
                </form>
            </div>
        </header>

        <div class="mx-auto w-full max-w-[1680px] px-4 py-6 sm:px-6 lg:px-10 lg:py-8">
            <div class="flex gap-6">
                <!-- Sidebar -->
                <aside class="w-[260px] shrink-0">
                    <div class="h-full flex flex-col">
                        <div class="border-4 border-black bg-white p-5 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                            <div class="flex items-center gap-3">
                                <div class="h-14 w-14 rounded-full border-2 border-black bg-[#d1d5db] flex items-center justify-center text-xl font-black">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                                <div>
                                    <div class="text-sm font-black">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-slate-700">SUPER ADMIN</div>
                                </div>
                            </div>
                        </div>

                        <nav class="mt-6 space-y-3">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 border-4 border-slate-900 px-4 py-3 bg-[#5cf47a] font-black">DASHBOARD</a>
                            <a href="{{ route('admin.alumni.index') }}" class="flex items-center gap-3 border-4 border-slate-900 px-4 py-3 bg-white font-black">ALUMNI</a>
                            <a href="{{ route('admin.users.edit', auth()->id()) }}" class="flex items-center gap-3 border-4 border-slate-900 px-4 py-3 bg-white font-black">PENGATURAN PROFIL</a>
                        </nav>

                        <div class="mt-auto">
                            <a href="{{ url('/') }}" class="block w-full text-center border-4 border-slate-900 bg-[#8e36dc] px-4 py-3 font-black text-white">BERANDA</a>
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <section class="flex-1">
                    <div class="grid gap-6 lg:grid-cols-[420px_1fr]">
                        <!-- Verifikasi besar -->
                        <div class="border-4 border-black bg-[#5cf47a] p-6 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                            <h3 class="text-sm font-black uppercase">Verifikasi Alumni</h3>
                            <p class="mt-2 text-xs text-slate-900">NOMOR INDUK MAHASISWA (NIM)</p>
                            <form method="GET" action="{{ route('admin.alumni.index') }}" class="mt-4">
                                <input name="nim" placeholder="Contoh: 201044100" class="w-full h-14 border-2 border-black bg-white px-4 font-black text-lg" />
                                <button class="mt-4 w-full h-14 bg-black text-white font-black">VERIFIKASI SEKARANG</button>
                            </form>
                        </div>

                        <!-- Keterserapan + statistik -->
                        <div class="grid gap-4">
                            <div class="border-4 border-black bg-white p-6 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                                <h3 class="text-sm font-black uppercase">Keterserapan Alumni</h3>
                                <div class="mt-4 flex items-center gap-6">
                                        <div class="flex-1 h-40 bg-[#f3f3f3] border border-black flex items-center justify-center">[Grafik garis]</div>
                                        <div class="w-64 grid gap-3">
                                            <div class="relative border-2 border-black p-4 bg-white">
                                                <div class="absolute -top-3 right-3">
                                                    <a href="{{ route('admin.alumni.export') }}" class="inline-block border-2 border-black bg-white px-3 py-1 text-xs font-black">UNDuh PDF</a>
                                                </div>
                                                <div class="text-xs font-black">Rate Keterserapan</div>
                                                <div class="mt-2 text-3xl font-black">{{ $employmentRate }}%</div>
                                            </div>
                                            <div class="border-2 border-black p-4 bg-[#f7ecff]">
                                                <div class="text-xs font-black">Alumni Tercatat</div>
                                                <div class="mt-2 text-3xl font-black">{{ $totalAlumni }}</div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="grid gap-6 lg:grid-cols-2">
                                <div class="border-4 border-black bg-white shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                                    <div class="bg-black px-4 py-2 text-white font-black">Recently Verified</div>
                                    <div class="p-4">
                                        @forelse($recentVerified as $rv)
                                            @php
                                                $initial = strtoupper(substr($rv->name,0,1));
                                                $bg = ['#7c3aed','#0f172a','#6d28d9','#ef4444','#06b6d4'];
                                                $color = $bg[crc32($rv->id) % count($bg)];
                                            @endphp
                                            <div class="flex items-center justify-between border-t pt-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-10 w-10 rounded-full flex items-center justify-center font-black text-white" style="background: {{ $color }}; border: 3px solid #fff; box-shadow: 0 2px 0 rgba(0,0,0,0.08);">{{ $initial }}</div>
                                                    <div>
                                                        <div class="font-black">{{ $rv->name }}</div>
                                                        <div class="text-xs text-slate-600">NIM: {{ $rv->nim ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    <div class="h-7 w-7 rounded-full border-2 border-green-600 text-green-600 font-black flex items-center justify-center">✓</div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-sm text-slate-600">Belum ada verifikasi terbaru.</div>
                                        @endforelse
                                    </div>
                                    <div class="bg-gray-100 text-center py-2 font-black text-xs">Lihat Semua</div>
                                </div>

                                <div class="border-4 border-black bg-white shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                                    <div class="bg-black px-4 py-2 text-white font-black">System Logs</div>
                                    <div class="p-4 text-xs text-slate-700">
                                        @foreach($systemLogs as $log)
                                            <div class="border-t pt-2 flex gap-3">
                                                <div class="w-1" style="background: {{ $loop->first ? '#10b981' : '#c7d2fe' }}"></div>
                                                <div>
                                                    <div class="font-medium text-[12px] text-slate-900">{{ $log['time']->diffForHumans() }}</div>
                                                    <div class="mt-1">{{ $log['message'] }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>