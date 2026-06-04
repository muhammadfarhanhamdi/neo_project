<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pelamar - NextStep</title>
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
                    <a href="{{ route('perusahaan.pelamar') }}" class="mb-4 inline-block text-sm font-bold">&larr; Kembali ke daftar pelamar</a>

                    @if (session('success'))
                        <div class="mb-4 border-2 border-green-900 bg-green-100 px-4 py-3 text-sm font-semibold text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid gap-5 xl:grid-cols-[2fr_1fr]">
                        <article class="border-4 border-slate-900 bg-white p-5 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                            <div class="flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <h1 class="text-2xl font-black">{{ $application->name }}</h1>
                                    <p class="mt-1 text-sm text-slate-600">{{ $application->email }}</p>
                                    <p class="mt-1 text-sm font-semibold text-slate-700">Lowongan: {{ optional($application->lowongan)->title ?: 'Lowongan dihapus' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[11px] font-black uppercase tracking-[0.15em] text-slate-600">Status Saat Ini</p>
                                    <p class="mt-1 inline-flex border-2 border-slate-900 bg-white px-3 py-1 text-sm font-black uppercase">{{ ucfirst($application->status) }}</p>
                                </div>
                            </div>

                            <section class="mt-6 border-t-2 border-slate-900 pt-4">
                                <h2 class="text-base font-black uppercase">Cover Letter</h2>
                                <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">{{ $application->cover_letter ?: 'Pelamar tidak mengirim cover letter.' }}</p>
                            </section>

                            <section class="mt-6 border-t-2 border-slate-900 pt-4">
                                <h2 class="text-base font-black uppercase">Riwayat Status</h2>
                                <div class="mt-3 space-y-2">
                                    @forelse(($application->status_history ?? []) as $history)
                                        <div class="flex items-center justify-between border-2 border-slate-900 bg-white px-3 py-2 text-xs">
                                            <span class="font-black uppercase">{{ $history['status'] ?? '-' }}</span>
                                            <span class="text-slate-600">{{ $history['at'] ?? '-' }}</span>
                                        </div>
                                    @empty
                                        <p class="text-sm text-slate-600">Belum ada riwayat status.</p>
                                    @endforelse
                                </div>
                            </section>
                        </article>

                        <aside class="space-y-4">
                            <div class="border-4 border-slate-900 bg-white p-4 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                <h3 class="text-sm font-black uppercase tracking-[0.15em]">Dokumen CV</h3>
                                @if($application->cv_path)
                                    <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="mt-3 inline-flex w-full items-center justify-center border-2 border-slate-900 bg-[#d9f4ff] px-3 py-3 text-xs font-black uppercase tracking-[0.12em]">Lihat CV</a>
                                @else
                                    <p class="mt-3 text-sm text-slate-600">Pelamar belum mengunggah CV.</p>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('applications.updateStatus', $application->id) }}" class="border-4 border-slate-900 bg-white p-4 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                @csrf
                                <h3 class="text-sm font-black uppercase tracking-[0.15em]">Validasi Lamaran</h3>

                                <label class="mt-3 mb-2 block text-[10px] font-black uppercase tracking-[0.16em] text-slate-600">Pilih Status</label>
                                <select name="status" class="h-11 w-full border-2 border-slate-900 bg-white px-3 text-xs font-black uppercase outline-none">
                                    <option value="submitted" {{ $application->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                    <option value="review" {{ $application->status === 'review' ? 'selected' : '' }}>Review</option>
                                    <option value="interview" {{ $application->status === 'interview' ? 'selected' : '' }}>Interview</option>
                                    <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>

                                <button type="submit" class="mt-3 inline-flex h-11 w-full items-center justify-center border-2 border-slate-900 bg-[#5cf47a] text-xs font-black uppercase tracking-[0.12em]">Simpan Validasi</button>
                            </form>

                            <div class="border-4 border-slate-900 bg-[#f7ecff] p-4 text-sm text-slate-700 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                Gunakan status Review/Interview untuk proses seleksi bertahap sebelum keputusan akhir.
                            </div>
                        </aside>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>