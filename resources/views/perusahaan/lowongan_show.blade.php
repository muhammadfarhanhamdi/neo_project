<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Lowongan - Perusahaan - NextStep</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f7f7f7] text-slate-950 pl-60">
    <main class="min-h-screen">
        <div class="mx-auto w-full max-w-[1680px]">
            @include('perusahaan.sidebar', ['active' => 'lowongans'])

            <section class="border-l-2 border-slate-900 bg-white">
                <header class="border-b-2 border-slate-900 bg-[#0f172a] text-white">
                    <div class="flex items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
                        <div class="text-[11px] font-black uppercase tracking-[0.24em] text-[#d9b2ff]">Detail Lowongan Perusahaan</div>
                        <div class="ml-auto text-[13px] font-black uppercase tracking-[0.14em] text-white">
                            {{ auth()->user()->name }}
                        </div>
                    </div>
                </header>

                @php
                    $requirements = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string) $lowongan->requirements)));
                    $descriptionLines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string) $lowongan->description)));
                    $applicationCount = $latestApplications->count();
                @endphp

                <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                    <a href="{{ route('perusahaan.lowongans') }}" class="mb-5 inline-flex items-center gap-2 border-2 border-slate-900 bg-white px-4 py-2 text-sm font-black uppercase tracking-[0.16em] text-slate-900 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">&larr; Kembali ke Lowongan Saya</a>

                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]">
                        <div class="space-y-5">
                            <section class="overflow-hidden border-4 border-slate-900 bg-white shadow-[8px_8px_0_rgba(0,0,0,0.22)]">
                                <div class="bg-[#d9b2ff] px-6 py-6 sm:px-8 sm:py-8">
                                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                                        <div class="max-w-3xl">
                                            <div class="inline-flex items-center gap-2 border-2 border-slate-900 bg-slate-950 px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-white shadow-[3px_3px_0_rgba(0,0,0,0.18)]">
                                                {{ $lowongan->is_featured ? 'Lowongan Unggulan' : 'Lowongan Aktif' }}
                                            </div>
                                            <h1 class="mt-4 text-4xl font-black uppercase leading-[0.92] sm:text-6xl">{{ $lowongan->title }}</h1>
                                            <p class="mt-4 max-w-2xl text-base leading-7 text-slate-900 sm:text-lg">{{ $lowongan->company }} · {{ $lowongan->location ?: 'Lokasi belum diisi' }}</p>

                                            <div class="mt-5 flex flex-wrap gap-2">
                                                <span class="border-2 border-slate-900 bg-[#5cf47a] px-3 py-1 text-xs font-black uppercase tracking-[0.14em] text-slate-950 shadow-[3px_3px_0_rgba(0,0,0,0.14)]">{{ $lowongan->type ?: 'Tipe belum ditentukan' }}</span>
                                                <span class="border-2 border-slate-900 bg-[#8e36dc] px-3 py-1 text-xs font-black uppercase tracking-[0.14em] text-white shadow-[3px_3px_0_rgba(0,0,0,0.14)]">{{ $lowongan->seniority ?: 'Semua level' }}</span>
                                                <span class="border-2 border-slate-900 bg-[#ffe36f] px-3 py-1 text-xs font-black uppercase tracking-[0.14em] text-slate-950 shadow-[3px_3px_0_rgba(0,0,0,0.14)]">{{ $lowongan->salary_range ?: 'Gaji negosiasi' }}</span>
                                            </div>
                                        </div>

                                        <div class="min-w-[180px] border-4 border-slate-900 bg-[#5cf47a] p-4 shadow-[6px_6px_0_rgba(0,0,0,0.2)]">
                                            <p class="text-[10px] font-black uppercase tracking-[0.22em] text-slate-500">Pelamar</p>
                                            <div class="mt-2 text-5xl font-black text-[#8e36dc]">{{ $applicationCount }}</div>
                                            <p class="mt-1 text-xs font-semibold text-slate-700">Total pelamar yang masuk</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t-4 border-slate-900 px-6 py-5 sm:px-8">
                                    <div class="grid gap-4 md:grid-cols-3">
                                        <div class="border-2 border-slate-900 bg-[#f7ecff] p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#8e36dc]">Perusahaan</p>
                                            <p class="mt-2 text-lg font-black text-slate-950">{{ $lowongan->company }}</p>
                                        </div>
                                        <div class="border-2 border-slate-900 bg-[#dffde4] p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#16944b]">Lokasi</p>
                                            <p class="mt-2 text-lg font-black text-slate-950">{{ $lowongan->location ?: 'Belum diisi' }}</p>
                                        </div>
                                        <div class="border-2 border-slate-900 bg-[#fff0a6] p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#9c6a00]">Kompensasi</p>
                                            <p class="mt-2 text-lg font-black text-slate-950">{{ $lowongan->salary_range ?: 'Negosiasi' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="border-4 border-slate-900 bg-[#ffffff] p-6 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                                <div class="flex items-center justify-between gap-4 border-b-4 border-slate-900 pb-3">
                                    <h2 class="text-xl font-black uppercase">Deskripsi Pekerjaan</h2>
                                    <span class="border-2 border-slate-900 bg-[#5cf47a] px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-slate-950">Tentang posisi</span>
                                </div>

                                <div class="mt-5 space-y-4 text-sm leading-8 text-slate-700">
                                    @if(!empty($descriptionLines))
                                        @foreach($descriptionLines as $line)
                                            <p class="border-l-4 border-[#8e36dc] bg-[#faf7ff] px-4 py-3">{{ $line }}</p>
                                        @endforeach
                                    @else
                                        <p>Deskripsi pekerjaan belum diisi oleh perusahaan.</p>
                                    @endif
                                </div>
                            </section>

                            <section class="border-4 border-slate-900 bg-[#ffffff] p-6 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                                <div class="flex items-center justify-between gap-4 border-b-4 border-slate-900 pb-3">
                                    <h3 class="text-xl font-black uppercase">Persyaratan</h3>
                                    <span class="border-2 border-slate-900 bg-[#d9b2ff] px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-slate-950">Kualifikasi</span>
                                </div>

                                <div class="mt-5 space-y-3">
                                    @forelse($requirements as $idx => $req)
                                        <div class="flex items-start gap-4 border-2 border-slate-900 bg-[#f7ecff] px-4 py-3 shadow-[4px_4px_0_rgba(0,0,0,0.10)]">
                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center border-2 border-slate-900 bg-[#5cf47a] text-xs font-black">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                            <p class="pt-1 text-sm leading-7 text-slate-700">{{ trim($req) }}</p>
                                        </div>
                                    @empty
                                        <div class="border-2 border-dashed border-slate-400 bg-[#f8f8f8] px-4 py-5 text-sm text-slate-600">Persyaratan belum diisi.</div>
                                    @endforelse
                                </div>
                            </section>

                            <section class="border-4 border-slate-900 bg-[#ffffff] p-6 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                                <div class="flex items-center justify-between gap-4 border-b-4 border-slate-900 pb-3">
                                    <h3 class="text-xl font-black uppercase">Pelamar Terbaru</h3>
                                    <a href="{{ route('perusahaan.pelamar') }}?lowongan_id={{ $lowongan->id }}" class="border-2 border-slate-900 bg-[#8e36dc] px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-white">Lihat Semua</a>
                                </div>

                                <div class="mt-5 space-y-3">
                                    @forelse($latestApplications as $app)
                                        <article class="flex items-center justify-between gap-4 border-2 border-slate-900 bg-[#f7ecff] p-4 shadow-[4px_4px_0_rgba(0,0,0,0.10)]">
                                            <div class="min-w-0">
                                                <p class="truncate text-sm font-black text-slate-950">{{ $app->name }}</p>
                                                <p class="truncate text-xs text-slate-600">{{ $app->email }}</p>
                                            </div>
                                            <div class="inline-flex items-center border-2 border-slate-900 px-3 py-1 text-[10px] font-black uppercase tracking-[0.14em] {{ $app->status === 'accepted' ? 'bg-[#5cf47a]' : ($app->status === 'rejected' ? 'bg-[#ff8c8c] text-white' : 'bg-[#ffe36f]') }}">
                                                {{ ucfirst($app->status) }}
                                            </div>
                                        </article>
                                    @empty
                                        <div class="border-2 border-slate-900 bg-[#f8f8f8] p-4 text-sm text-slate-600">Belum ada pelamar.</div>
                                    @endforelse
                                </div>
                            </section>
                        </div>

                        <aside class="h-fit space-y-5">
                            <div class="border-4 border-slate-900 bg-white p-6 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#8e36dc]">Aksi Cepat</p>
                                <a href="{{ route('perusahaan.pelamar') }}?lowongan_id={{ $lowongan->id }}" class="mt-3 inline-flex w-full items-center justify-center border-2 border-slate-900 bg-[#8e36dc] px-4 py-3 text-xs font-black uppercase tracking-[0.16em] text-white shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Lihat Pelamar</a>
                            </div>

                            <div class="border-4 border-slate-900 bg-[#f7ecff] p-6 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#8e36dc]">Catatan</p>
                                <p class="mt-3 text-sm leading-7 text-slate-700">Halaman ini hanya untuk perusahaan pemilik lowongan. Semua informasi di sini mengikuti data lowongan yang sedang aktif.</p>
                            </div>
                        </aside>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>