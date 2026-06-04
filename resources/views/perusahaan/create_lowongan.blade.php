<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Buat Lowongan - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#ececec] text-slate-950 pl-60">
        <main class="min-h-screen">
            <div class="mx-auto w-full max-w-[1680px] gap-6 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                @include('perusahaan.sidebar', ['active' => 'create'])

                <section class="rounded-[2px] border-4 border-slate-900 bg-white p-5 shadow-[10px_10px_0_rgba(15,23,42,0.3)] sm:p-6">
                    @if ($errors->any())
                        <div class="mb-5 rounded-[2px] border-2 border-red-900 bg-red-100 p-4 text-sm text-red-800">
                            <p class="font-black">Periksa kembali form berikut:</p>
                            <ul class="mt-2 list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-5 rounded-[2px] border-2 border-green-900 bg-green-100 p-4 text-sm font-semibold text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('lowongan.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Judul Posisi</label>
                            <input name="title" value="{{ old('title') }}" required placeholder="Contoh: Senior Frontend Developer"
                                class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none placeholder:text-slate-400 focus:bg-slate-50" />
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Nama Perusahaan</label>
                                <input name="company" value="{{ old('company', auth()->user()->name) }}" required placeholder="PT Nama Perusahaan"
                                    class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none placeholder:text-slate-400 focus:bg-slate-50" />
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Lokasi</label>
                                <input name="location" value="{{ old('location') }}" placeholder="Jakarta / Remote / Hybrid"
                                    class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none placeholder:text-slate-400 focus:bg-slate-50" />
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Lama Kerja</label>
                                <input name="lama_kerja" value="{{ old('lama_kerja') }}" placeholder="Contoh: 1 tahun / 6 bulan"
                                    class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none placeholder:text-slate-400 focus:bg-slate-50" />
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Tipe</label>
                                <select name="type" class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-3 text-sm outline-none focus:bg-slate-50">
                                    <option value="">Pilih tipe kerja</option>
                                    <option value="Full-time" @selected(old('type') === 'Full-time')>Full-time</option>
                                    <option value="Part-time" @selected(old('type') === 'Part-time')>Part-time</option>
                                    <option value="Contract" @selected(old('type') === 'Contract')>Contract</option>
                                    <option value="Internship" @selected(old('type') === 'Internship')>Internship</option>
                                </select>
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Seniority</label>
                                <select name="seniority" class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-3 text-sm outline-none focus:bg-slate-50">
                                    <option value="">Pilih level</option>
                                    <option value="Entry" @selected(old('seniority') === 'Entry')>Entry</option>
                                    <option value="Mid" @selected(old('seniority') === 'Mid')>Mid</option>
                                    <option value="Senior" @selected(old('seniority') === 'Senior')>Senior</option>
                                    <option value="Lead" @selected(old('seniority') === 'Lead')>Lead</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Range Gaji</label>
                            <input name="salary_range" value="{{ old('salary_range') }}" placeholder="Rp 8jt - Rp 15jt"
                                class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none placeholder:text-slate-400 focus:bg-slate-50" />
                        </div>

                        <div>
                            <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Deskripsi Pekerjaan</label>
                            <textarea name="description" rows="6" placeholder="Jelaskan tanggung jawab utama posisi ini..."
                                class="w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 py-3 text-sm leading-7 outline-none placeholder:text-slate-400 focus:bg-slate-50">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Persyaratan</label>
                            <textarea name="requirements" rows="6" placeholder="Pisahkan setiap requirement dengan baris baru"
                                class="w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 py-3 text-sm leading-7 outline-none placeholder:text-slate-400 focus:bg-slate-50">{{ old('requirements') }}</textarea>
                        </div>

                        <label class="flex items-center gap-3 rounded-[2px] border-2 border-slate-900 bg-[#f7f7f7] px-4 py-3">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) class="h-4 w-4 rounded border-slate-900" />
                            <span class="text-sm font-semibold">Tampilkan sebagai lowongan unggulan</span>
                        </label>

                        <div class="flex flex-wrap gap-3 pt-2">
                            <button type="submit" class="rounded-[2px] border-2 border-slate-900 bg-[#5cf47a] px-5 py-3 text-xs font-black uppercase tracking-[0.16em] text-slate-950 shadow-[5px_5px_0_rgba(15,23,42,0.2)] transition hover:-translate-y-0.5">
                                Publish Lowongan
                            </button>
                            <a href="{{ route('perusahaan.dashboard') }}" class="rounded-[2px] border-2 border-slate-900 bg-white px-5 py-3 text-xs font-black uppercase tracking-[0.16em] text-slate-900">
                                Kembali
                            </a>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </body>
</html>
