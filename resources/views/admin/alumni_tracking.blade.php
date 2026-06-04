<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tracking Alumni by NIM - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f3f3f3] text-slate-950">
        <main class="min-h-screen">
            <header class="border-b-2 border-black bg-white">
                <div class="mx-auto flex max-w-[1680px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
                    <a href="{{ url('/') }}" class="text-2xl font-black tracking-tight text-slate-950">NextStep</a>
                    <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-900 lg:flex">
                        <a href="{{ route('admin.dashboard') }}" class="transition hover:underline">Dashboard</a>
                        <a href="{{ route('admin.alumni.index') }}" class="transition hover:underline">Tracking Alumni</a>
                    </nav>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-[2px] border-2 border-black bg-white px-3 py-2 text-xs font-black text-slate-950 shadow-[3px_3px_0_rgba(0,0,0,0.15)] sm:px-4">Logout</button>
                    </form>
                </div>
            </header>

            <div class="mx-auto w-full max-w-[1680px] px-4 py-5 sm:px-6 lg:px-10 lg:py-6">
                <section class="rounded-none border-2 border-black bg-[#62f26f] px-6 py-6 shadow-[4px_4px_0_rgba(0,0,0,0.12)] sm:px-8">
                    <h1 class="text-3xl font-black leading-tight text-slate-950 sm:text-5xl">Tracking Alumni Kampus</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-900 sm:text-base">Cari alumni berdasarkan NIM untuk melihat status sudah diterima kerja atau belum.</p>
                </section>

                <section class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                    <div class="border-4 border-black bg-white p-4 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                        <div class="bg-black px-3 py-2 text-white font-black text-sm">Total Alumni (NIM)</div>
                        <div class="mt-3 text-3xl font-black text-slate-950">{{ $totalWithNim }}</div>
                    </div>
                    <div class="border-4 border-black bg-[#d7ffd8] p-4 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                        <div class="bg-black px-3 py-2 text-white font-black text-sm">Sudah Diterima</div>
                        <div class="mt-3 text-3xl font-black text-slate-950">{{ $employedCount }}</div>
                    </div>
                    <div class="border-4 border-black bg-[#ffe2df] p-4 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                        <div class="bg-black px-3 py-2 text-white font-black text-sm">Belum Diterima</div>
                        <div class="mt-3 text-3xl font-black text-slate-950">{{ $unemployedCount }}</div>
                    </div>
                    <div class="border-4 border-black bg-[#f7ecff] p-4 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                        <div class="bg-black px-3 py-2 text-white font-black text-sm">Kelengkapan NIM</div>
                        <div class="mt-3 text-3xl font-black text-slate-950">{{ max(100 - ($missingNimCount > 0 && ($missingNimCount + $totalWithNim) > 0 ? (int) round(($missingNimCount / ($missingNimCount + $totalWithNim)) * 100) : 0), 0) }}%</div>
                    </div>
                    <div class="border-4 border-black bg-[#e9f2ff] p-4 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                        <div class="bg-black px-3 py-2 text-white font-black text-sm">Employment Rate</div>
                        <div class="mt-3 text-3xl font-black text-slate-950">{{ $employmentRate }}%</div>
                    </div>
                </section>

                <section class="mt-5 border-4 border-black bg-white shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                    <div class="bg-black px-4 py-2 text-white font-black">Pencarian & Filter</div>
                    <div class="p-4">
                        <form method="GET" action="{{ route('admin.alumni.index') }}" class="grid gap-3 md:grid-cols-[1fr_220px_auto]">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Cari berdasarkan NIM</label>
                                <input type="text" name="nim" value="{{ $nim }}" placeholder="Contoh: 2210112345" class="mt-2 h-12 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white font-black" />
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Filter Status Kerja</label>
                                <select name="status" class="mt-2 h-12 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white font-black">
                                    <option value="all" @selected($statusFilter === 'all')>Semua</option>
                                    <option value="employed" @selected($statusFilter === 'employed')>Sudah Diterima</option>
                                    <option value="unemployed" @selected($statusFilter === 'unemployed')>Belum Diterima</option>
                                </select>
                            </div>
                            <div class="flex items-end gap-3">
                                <button type="submit" class="h-12 border-4 border-black bg-[#62f26f] px-4 text-sm font-black text-slate-950">Cari</button>
                                <a href="{{ route('admin.alumni.index') }}" class="h-12 border-4 border-black bg-white px-4 text-sm font-black text-slate-950 inline-flex items-center justify-center">Reset</a>
                                <a href="{{ route('admin.alumni.export', ['nim' => $nim, 'status' => $statusFilter]) }}" class="h-12 border-4 border-black bg-[#f7ecff] px-4 text-sm font-black text-slate-950 inline-flex items-center">Export PDF</a>
                                <a href="{{ route('admin.alumni.export.excel', ['nim' => $nim, 'status' => $statusFilter]) }}" class="h-12 border-4 border-black bg-[#e9f2ff] px-4 text-sm font-black text-slate-950 inline-flex items-center">Export Excel</a>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="mt-5 border-4 border-black bg-white shadow-[8px_8px_0_rgba(0,0,0,0.18)] overflow-hidden">
                    <div class="bg-black px-4 py-2 text-white font-black">Daftar Alumni</div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="border-b-2 border-black bg-[#f7ecff] text-left text-xs font-black uppercase tracking-[0.16em] text-slate-700">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Profil</th>
                                    <th class="px-4 py-3">Total Lamaran</th>
                                    <th class="px-4 py-3">Status Kerja</th>
                                    <th class="px-4 py-3">Keterangan</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alumni as $index => $item)
                                    @php
                                        $accepted = $item->accepted_application;
                                        $initial = strtoupper(substr($item->name,0,1));
                                        $avatarBg = ['#7c3aed','#0f172a','#6d28d9','#ef4444','#06b6d4'];
                                        $color = $avatarBg[crc32($item->id) % count($avatarBg)];
                                    @endphp
                                    <tr class="border-b border-black/20">
                                        <td class="px-4 py-3 font-semibold">{{ $alumni->firstItem() + $index }}</td>
                                        <td class="px-4 py-3 flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center font-black text-white" style="background: {{ $color }}">{{ $initial }}</div>
                                            <div>
                                                <div class="font-black">{{ $item->name }}</div>
                                                <div class="text-xs text-slate-600">{{ $item->nim }} • {{ $item->email }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">{{ $item->total_applications }}</td>
                                        <td class="px-4 py-3">
                                            @if($item->is_employed)
                                                <span class="inline-flex items-center border-2 border-black bg-[#62f26f] px-2 py-1 text-xs font-black">Sudah Diterima</span>
                                            @else
                                                <span class="inline-flex items-center border-2 border-black bg-[#ffd6d3] px-2 py-1 text-xs font-black text-rose-700">Belum Diterima</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-xs text-slate-700">
                                            @if($accepted && $accepted->lowongan)
                                                {{ $accepted->lowongan->company }} • {{ $accepted->lowongan->title }}
                                            @else
                                                Belum ada status accepted
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.alumni.show', $item->id) }}" class="inline-block border-2 border-black bg-white px-3 py-1 text-xs font-black">Lihat</a>
                                            <a href="{{ route('admin.alumni.export', ['nim' => $item->nim]) }}" class="inline-block border-2 border-black bg-[#f7ecff] px-3 py-1 text-xs font-black ml-2">PDF</a>
                                            <a href="{{ route('admin.alumni.export.excel', ['nim' => $item->nim]) }}" class="inline-block border-2 border-black bg-[#e9f2ff] px-3 py-1 text-xs font-black ml-2">Excel</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-600">Data alumni dengan NIM belum ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="mt-5 border-4 border-black bg-white shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                    <div class="bg-black px-4 py-2 text-white font-black">Pelamar Tanpa NIM</div>
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-slate-700">Daftar ini membantu admin menindaklanjuti kelengkapan profil alumni.</p>
                            <div class="border-2 border-black bg-[#ffe2df] px-3 py-2 text-xs font-black text-slate-950">Total: {{ $missingNimCount }}</div>
                        </div>

                        <div class="mt-4 grid gap-3">
                            @forelse($missingNimUsers as $missing)
                                <div class="flex items-center justify-between border-2 border-black bg-white p-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-[#e2e8f0] flex items-center justify-center font-black text-slate-900">{{ strtoupper(substr($missing->name,0,1)) }}</div>
                                        <div>
                                            <div class="font-black">{{ $missing->name }}</div>
                                            <div class="text-xs text-slate-600">{{ $missing->email }} • {{ $missing->phone_number ?: '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="mailto:{{ $missing->email }}" class="inline-block border-2 border-black bg-white px-3 py-1 text-xs font-black">Email</a>
                                        <a href="{{ route('admin.users.edit', $missing->id) }}" class="inline-block border-2 border-black bg-[#62f26f] px-3 py-1 text-xs font-black text-slate-950">Lengkapi</a>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-8 text-center text-sm text-slate-600">Semua pelamar sudah mengisi NIM.</div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <div class="mt-5">
                    {{ $alumni->links() }}
                </div>
            </div>
        </main>
    </body>
</html>
