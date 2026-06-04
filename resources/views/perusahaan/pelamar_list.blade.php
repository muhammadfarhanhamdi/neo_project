<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pelamar - NextStep</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-950 pl-60">
    <main class="min-h-screen">
        <div class="mx-auto w-full max-w-[1680px]">
            @include('perusahaan.sidebar', ['active' => 'pelamar'])

            <section class="border-l-2 border-slate-900 bg-white">
                <header class="border-b-2 border-slate-900 bg-white">
                    <div class="flex items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
                        <div class="ml-auto text-[13px] font-black uppercase tracking-[0.14em] text-slate-900">
                            {{ auth()->user()->name }}
                        </div>
                    </div>
                </header>

                <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h1 class="text-3xl font-black uppercase">Pelamar</h1>
                            <p class="mt-2 text-sm text-slate-700">Daftar pelamar untuk lowongan Anda, termasuk akses CV dan validasi status.</p>
                        </div>
                        <a href="{{ route('perusahaan.lowongans') }}" class="inline-flex items-center gap-2 border-4 border-slate-900 bg-[#8e36dc] px-4 py-3 text-xs font-black uppercase tracking-[0.12em] text-white shadow-[5px_5px_0_rgba(0,0,0,0.28)]">Lihat Lowongan</a>
                    </div>

                    @if (session('success'))
                        <div class="mt-4 border-2 border-green-900 bg-green-100 px-4 py-3 text-sm font-semibold text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('perusahaan.pelamar') }}" class="mt-5 flex flex-wrap items-end gap-3 border-4 border-slate-900 bg-white p-4 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                        <div>
                            <label for="lowongan_id" class="mb-2 block text-[11px] font-black uppercase tracking-[0.2em] text-slate-700">Filter Lowongan</label>
                            <select id="lowongan_id" name="lowongan_id" class="h-11 min-w-[220px] border-2 border-slate-900 bg-white px-3 text-sm outline-none">
                                <option value="">Semua Lowongan</option>
                                @foreach(($companyLowongans ?? collect()) as $l)
                                    <option value="{{ $l->id }}" {{ (string)($selectedLowonganId ?? '') === (string)$l->id ? 'selected' : '' }}>{{ $l->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="h-11 border-2 border-slate-900 bg-[#5cf47a] px-4 text-xs font-black uppercase tracking-[0.15em]">Terapkan</button>
                        <a href="{{ route('perusahaan.pelamar') }}" class="h-11 border-2 border-slate-900 bg-white px-4 text-xs font-black uppercase tracking-[0.15em] inline-flex items-center">Reset</a>
                    </form>

                    <div class="mt-6 space-y-4">
                        @forelse($applications as $app)
                            @php
                                $status = $app->status;
                                $statusClass = match ($status) {
                                    'accepted' => 'bg-[#5cf47a] text-slate-950',
                                    'rejected' => 'bg-[#ffd6d3] text-rose-800',
                                    'interview' => 'bg-[#e9d8ff] text-[#6b21a8]',
                                    'review' => 'bg-[#fde68a] text-slate-900',
                                    default => 'bg-white text-slate-800',
                                };
                            @endphp

                            <article class="border-4 border-slate-900 bg-white p-4 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                                    <div class="flex items-center gap-3">
                                        @if(optional($app->user)->profile_photo_path)
                                            <img src="{{ asset('storage/' . $app->user->profile_photo_path) }}" alt="{{ $app->name }}" class="h-12 w-12 border-2 border-slate-900 object-cover" />
                                        @else
                                            <div class="flex h-12 w-12 items-center justify-center border-2 border-slate-900 bg-white text-xs font-black">{{ strtoupper(substr($app->name, 0, 2)) }}</div>
                                        @endif
                                        <div>
                                            <h3 class="text-lg font-black">{{ $app->name }}</h3>
                                            <p class="mt-1 text-sm text-slate-600">{{ optional($app->lowongan)->title ?: 'Lowongan dihapus' }}</p>
                                            <p class="mt-1 text-xs font-black text-[#8e36dc]">{{ $app->email }}</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-stretch gap-2 xl:items-end">
                                        <span class="inline-flex items-center justify-center border-2 border-slate-900 px-3 py-2 text-[11px] font-black uppercase {{ $statusClass }}">{{ ucfirst($status) }}</span>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('perusahaan.pelamar.show', $app->id) }}" class="inline-flex items-center justify-center border-2 border-slate-900 bg-white px-3 py-2 text-xs font-black">Detail</a>
                                            @if($app->cv_path)
                                                <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="inline-flex items-center justify-center border-2 border-slate-900 bg-[#d9f4ff] px-3 py-2 text-xs font-black">Lihat CV</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('applications.updateStatus', $app->id) }}" class="mt-4 flex flex-wrap items-end gap-2 border-t-2 border-slate-900 pt-3">
                                    @csrf
                                    <div>
                                        <label class="mb-1 block text-[10px] font-black uppercase tracking-[0.14em] text-slate-700">Validasi Status</label>
                                        <select name="status" class="h-10 border-2 border-slate-900 bg-white px-3 text-xs font-black uppercase outline-none">
                                            <option value="submitted" {{ $status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                            <option value="review" {{ $status === 'review' ? 'selected' : '' }}>Review</option>
                                            <option value="interview" {{ $status === 'interview' ? 'selected' : '' }}>Interview</option>
                                            <option value="accepted" {{ $status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="h-10 border-2 border-slate-900 bg-[#5cf47a] px-4 text-xs font-black uppercase">Simpan Status</button>
                                </form>
                            </article>
                        @empty
                            <div class="border-4 border-slate-900 bg-white p-6 text-sm font-semibold text-slate-600 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">Belum ada pelamar.</div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $applications->appends(request()->query())->links() }}
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>