<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Lowongan - NextStep</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f3f3] text-slate-950">
    <main class="min-h-screen pb-8">
        <header class="border-b-2 border-black bg-white shadow-[0_2px_0_rgba(0,0,0,0.08)]">
            <div class="mx-auto flex flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-10">
                <a href="{{ url('/') }}" class="text-2xl font-black tracking-tight text-slate-950">NextStep</a>
                <nav class="flex flex-wrap items-center gap-4 text-sm font-semibold text-slate-900">
                    <a href="{{ url('/') }}" class="transition hover:underline">Beranda</a>
                    <a href="{{ url('/lowongan') }}" class="transition hover:underline">Lowongan</a>
                    <a href="{{ route('pelamar.dashboard') }}" class="transition hover:underline">Dashboard</a>
                    <a href="{{ route('pelamar.riwayat') }}" class="transition hover:underline">Riwayat</a>
                </nav>
            </div>
        </header>

        @php
            $requirements = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string) $lowongan->requirements)));
            $descriptionLines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string) $lowongan->description)));
            $descriptionLead = $descriptionLines[0] ?? 'Kami mencari kandidat yang bersedia belajar cepat dan memberi dampak nyata.';
            $descriptionBullets = count($descriptionLines) > 1 ? array_slice($descriptionLines, 1, 3) : [
                'Mampu bekerja terstruktur dan rapi.',
                'Komunikatif dan suka berkolaborasi.',
                'Siap beradaptasi dengan target tim.',
            ];
        @endphp

        <div class="mx-auto w-full max-w-[1680px] px-4 py-5 sm:px-6 lg:px-10 lg:py-6">
            <a href="{{ url('/lowongan') }}" class="mb-5 inline-flex items-center gap-2 text-[11px] font-black uppercase tracking-[0.28em] text-slate-900">&larr; Kembali ke Listing</a>

            <div class="mx-auto grid max-w-[1180px] gap-12 lg:grid-cols-[670px_360px] xl:justify-center">
                <div class="space-y-10 max-w-[670px]">
                    <section class="rounded-[28px] border-2 border-black bg-white px-6 py-8 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                        <div class="inline-flex items-center rounded-full bg-[#62f26f] px-4 py-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-950 shadow-[0_4px_0_rgba(0,0,0,0.12)]">
                            Paling Cocok
                        </div>
                        <h1 class="mt-5 max-w-3xl text-5xl font-black uppercase leading-[0.92] tracking-[-0.04em] text-slate-950 sm:text-6xl">{{ $lowongan->title }}</h1>
                        <p class="mt-3 text-sm font-semibold text-slate-700 sm:text-base">{{ $lowongan->company }} · {{ $lowongan->location ?: 'Lokasi fleksibel' }}</p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <span class="rounded-full border-2 border-black bg-[#d9b2ff] px-4 py-2 text-[11px] font-black uppercase tracking-[0.14em] text-slate-950">{{ $lowongan->type ?: 'Full-time' }}</span>
                            <span class="rounded-full border-2 border-black bg-[#f7ecff] px-4 py-2 text-[11px] font-black uppercase tracking-[0.14em] text-slate-950">{{ $lowongan->seniority ?: 'Remote (ID)' }}</span>
                            @if($lowongan->lama_kerja)
                                <span class="rounded-full border-2 border-black bg-[#e6ffec] px-4 py-2 text-[11px] font-black uppercase tracking-[0.14em] text-slate-950">{{ $lowongan->lama_kerja }}</span>
                            @endif
                            <span class="rounded-full border-2 border-black bg-[#dcfce7] px-4 py-2 text-[11px] font-black uppercase tracking-[0.14em] text-slate-950">{{ $lowongan->salary_range ?: 'IDR 15 jt - 25 jt' }}</span>
                        </div>
                    </section>

                    <section class="border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)] sm:p-6">
                        <div class="flex items-center justify-between border-b-2 border-black pb-3">
                            <h2 class="text-xl font-black uppercase">Deskripsi Pekerjaan</h2>
                            <span class="text-[10px] font-black uppercase tracking-[0.22em] text-slate-700">Tentang posisi</span>
                        </div>

                        <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-700 sm:text-base">{{ $descriptionLead }}</p>

                        <div class="mt-4 space-y-2">
                            @foreach($descriptionBullets as $bullet)
                                <div class="flex items-start gap-3 text-sm leading-7 text-slate-700">
                                    <span class="mt-2 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full border border-[#8e36dc] text-[10px] text-[#8e36dc]">•</span>
                                    <span>{{ $bullet }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="rounded-[28px] border-2 border-black bg-white p-6 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                        <div class="flex items-center justify-between border-b border-black pb-3">
                            <h3 class="text-2xl font-black uppercase tracking-[0.04em] text-slate-950">Persyaratan</h3>
                            <span class="text-[11px] font-black uppercase tracking-[0.24em] text-slate-700">Kualifikasi</span>
                        </div>

                        <div class="mt-5 space-y-3">
                            @forelse($requirements as $idx => $req)
                                <div class="flex items-start gap-3 rounded-[18px] border-2 border-black bg-[#f7ecff] px-4 py-4">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border-2 border-black bg-[#62f26f] text-[11px] font-black text-slate-950">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    <p class="pt-0.5 text-sm leading-7 text-slate-700">{{ trim($req) }}</p>
                                </div>
                            @empty
                                <div class="rounded-[18px] border border-dashed border-slate-400 bg-[#f8fafc] px-4 py-5 text-sm text-slate-600">Persyaratan belum diisi oleh perusahaan.</div>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-[28px] border-2 border-black bg-[#dec8ff] p-6 shadow-[4px_4px_0_rgba(0,0,0,0.12)] sm:p-6">
                        <div class="flex items-center justify-between border-b border-black pb-3">
                            <h3 class="text-xl font-black uppercase text-slate-950">Tentang Perusahaan</h3>
                            <span class="text-[10px] font-black uppercase tracking-[0.22em] text-slate-700">Ringkasan</span>
                        </div>

                        <div class="mt-5 flex items-center gap-4">
                            <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full border-2 border-black bg-[#d9b2ff] text-3xl font-black text-slate-950">
                                {{ strtoupper(substr($lowongan->company ?? 'X', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-lg font-black text-slate-950">{{ $lowongan->company }}</p>
                                <p class="mt-2 text-sm leading-7 text-slate-700">{{ $lowongan->company }} sedang membuka kesempatan untuk bergabung dengan tim yang sedang berkembang.</p>
                            </div>
                        </div>
                    </section>
                </div>

                <aside id="apply" class="h-fit rounded-[32px] border-2 border-black bg-white p-10 shadow-[4px_4px_0_rgba(0,0,0,0.12)] text-slate-950">
                    <div class="rounded-[28px] border-2 border-black bg-[#f7ecff] p-7 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-[10px] font-black uppercase tracking-[0.24em] text-slate-700">Tinggal 1 langkah lagi</p>
                            <span class="text-[10px] font-black uppercase tracking-[0.24em] text-slate-700">90%</span>
                        </div>
                        <div class="mt-4 h-3 w-full overflow-hidden rounded-full bg-white">
                            <div class="h-full w-[90%] rounded-full bg-[#62f26f]"></div>
                        </div>
                        <h3 class="mt-5 text-3xl font-black uppercase tracking-[-0.03em] text-slate-950">Kirim Lamaranmu</h3>
                    </div>

                    <div class="mt-7 space-y-5">
                        <div class="rounded-[22px] border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-700">Posisi</p>
                            <p class="mt-2 text-sm font-black text-slate-950">{{ $lowongan->title }}</p>
                        </div>
                        <div class="rounded-[22px] border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-[#16a34a]">Perusahaan</p>
                            <p class="mt-2 text-sm font-black text-slate-950">{{ $lowongan->company }}</p>
                        </div>
                        <div class="rounded-[22px] border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-[#16a34a]">Lokasi</p>
                            <p class="mt-2 text-sm font-black text-slate-950">{{ $lowongan->location ?: 'Belum diisi' }}</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mt-4 border-2 border-red-900 bg-red-100 p-3 text-sm text-red-800">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mt-4 border-2 border-green-900 bg-green-100 p-3 text-sm text-green-800">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="mt-4 border-2 border-red-900 bg-red-100 p-3 text-sm text-red-800">{{ session('error') }}</div>
                    @endif

                    @auth
                        @if (auth()->user()->role === 'pelamar')
                            <div class="mt-6 rounded-[28px] border border-slate-200 bg-[#eff6ff] p-5 text-sm text-slate-950">
                                @if($isSaved)
                                    <form action="{{ route('lowongan.unsave', $lowongan->id) }}" method="post" class="flex flex-col gap-4 rounded-[22px] border border-slate-200 bg-white p-5 shadow-[0_16px_30px_rgba(15,23,42,0.06)]">
                                        @csrf
                                        @method('DELETE')
                                        <span class="font-black uppercase tracking-[0.12em] text-[#0284c7]">Lowongan ini ada di Simpananmu.</span>
                                        <button type="submit" class="w-full rounded-[14px] border border-[#0284c7] bg-[#0284c7] px-4 py-3 text-xs font-black uppercase tracking-[0.16em] text-white transition hover:bg-[#0369a1]">Hapus dari Simpanan</button>
                                    </form>
                                @else
                                    <form action="{{ route('lowongan.save', $lowongan->id) }}" method="post" class="flex flex-col gap-4 rounded-[22px] border border-slate-200 bg-white p-5 shadow-[0_16px_30px_rgba(15,23,42,0.06)]">
                                        @csrf
                                        <span class="font-black uppercase tracking-[0.12em] text-[#0284c7]">Simpan lowongan ini agar bisa dilihat lagi nanti.</span>
                                        <button type="submit" class="w-full rounded-[14px] border border-[#0284c7] bg-[#0284c7] px-4 py-3 text-xs font-black uppercase tracking-[0.16em] text-white transition hover:bg-[#0369a1]">Simpan Lowongan</button>
                                    </form>
                                @endif
                            </div>

                            @if ($userAccepted)
                                <div class="mt-5 border-2 border-red-900 bg-red-100 p-4 text-sm text-red-800">
                                    Anda sudah diterima dalam 6 bulan terakhir dan tidak dapat mengirim lamaran lagi.
                                    @if ($nextEligibleAt)
                                        Anda dapat melamar kembali setelah {{ $nextEligibleAt->format('d M Y') }}.
                                    @endif
                                </div>
                            @elseif ($alreadyApplied)
                                <div class="mt-5 border-2 border-yellow-900 bg-yellow-100 p-4 text-sm text-yellow-800">
                                    Anda sudah mengirim lamaran untuk lowongan ini dan tidak dapat mengirim ulang.
                                </div>
                            @else
                                <form action="{{ route('lowongan.apply', $lowongan->id) }}" method="post" enctype="multipart/form-data" class="mt-5 space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Nama Lengkap</label>
                                    <input name="name" type="text" value="{{ old('name', auth()->user()->name) }}" class="mt-2 h-10 w-full border-2 border-slate-900 bg-[#f7f7f7] px-3 text-sm outline-none" placeholder="Budi Santoso" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Alamat Email</label>
                                    <input name="email" type="email" value="{{ old('email', auth()->user()->email) }}" class="mt-2 h-10 w-full border-2 border-slate-900 bg-[#f7f7f7] px-3 text-sm outline-none" placeholder="budi@email.com" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Upload CV (PDF)</label>
                                    <div class="mt-2 border-2 border-dashed border-slate-900 bg-[#f7f7f7] px-4 py-6 text-center text-xs font-black uppercase tracking-[0.16em] text-slate-500">
                                        <input name="cv" type="file" class="w-full text-sm font-normal uppercase tracking-normal text-slate-700" />
                                    </div>
                                </div>

                                <button class="w-full rounded-[16px] border-2 border-black bg-[#62f26f] px-4 py-3 text-sm font-black uppercase tracking-[0.18em] text-slate-950 shadow-[4px_4px_0_rgba(0,0,0,0.12)] transition hover:bg-[#16a34a]">Kirim Lamaran</button>

                                <p class="text-[10px] uppercase tracking-[0.18em] text-slate-700">Dengan mengirim, Anda menyetujui syarat & ketentuan.</p>
                            </form>
                        @endif
                    @else
                        <div class="mt-5 border-2 border-slate-900 bg-[#f8f8f8] p-4 text-sm text-slate-700">
                            Akun perusahaan tidak dapat melamar lowongan. Gunakan akun pelamar untuk mengirim lamaran.
                        </div>
                    @endif
                    @else
                        <div class="mt-5 border-2 border-black bg-white p-4 text-sm text-slate-700">
                            Silakan login sebagai pelamar untuk mengirim lamaran.
                            <a href="{{ route('login') }}" class="mt-3 inline-block rounded-[2px] border-2 border-black bg-[#62f26f] px-3 py-2 text-xs font-black uppercase tracking-[0.14em] text-slate-950 shadow-[3px_3px_0_rgba(0,0,0,0.15)]">Masuk Sekarang</a>
                        </div>
                    @endauth
                </aside>
            </div>
        </div>

        <footer class="mt-8 border-t-2 border-slate-800 bg-slate-950 text-slate-300">
            <div class="mx-auto flex max-w-[1680px] flex-col gap-3 px-4 py-6 text-xs font-semibold sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-10">
                <div class="text-lg font-black text-white">NextStep</div>
                <div class="flex gap-8 text-slate-400">
                    <span>Tentang Kami</span>
                    <span>Pusat Bantuan</span>
                </div>
                <div class="text-[#c4b5fd]">© 2024 NextStep. Bangun Karirmu Sekarang.</div>
            </div>
        </footer>
    </main>
</body>
</html>
