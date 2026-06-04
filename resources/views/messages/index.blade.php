<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pesan - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f3f3f3] text-slate-950 {{ auth()->check() && auth()->user()->role === 'perusahaan' ? 'pl-60' : '' }}">
            @php
                $isCompany = auth()->check() && auth()->user()->role === 'perusahaan';
            @endphp

            <main class="min-h-screen">
                @if($isCompany)
                    <div class="mx-auto w-full max-w-[1680px]">
                        @include('perusahaan.sidebar', ['active' => 'messages'])

                        <section class="border-l-2 border-slate-900 bg-white pl-0">
                            <header class="border-b-2 border-slate-900 bg-white">
                                <div class="flex items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
                                    <div class="ml-auto text-[13px] font-black uppercase tracking-[0.14em] text-slate-900">
                                        {{ auth()->user()->name }}
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="border-2 border-slate-900 bg-[#ffd6d3] px-3 py-2 text-[11px] font-black uppercase tracking-[0.18em] text-rose-700">Logout</button>
                                    </form>
                                </div>
                            </header>

                            <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                                @if (session('success'))
                                    <div class="mb-5 border-2 border-green-900 bg-green-100 px-4 py-3 text-sm font-semibold text-green-800">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                                    <div class="max-w-4xl">
                                        <h1 class="text-4xl font-black uppercase leading-[0.92] sm:text-5xl">Pesan<br>Perusahaan</h1>
                                        <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-700 sm:text-base">Kirim pesan ke pelamar dan pantau semua percakapan dengan tampilan yang mengikuti dashboard perusahaan.</p>
                                    </div>

                                    <div class="border-4 border-slate-900 bg-[#61f275] p-5 shadow-[6px_6px_0_rgba(0,0,0,0.28)]">
                                        <div class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-800">Total Pesan</div>
                                        <div class="mt-1 text-5xl font-black leading-none">{{ $messages->total() }}</div>
                                    </div>
                                </div>

                                <div class="mt-7 grid gap-6 xl:grid-cols-[360px_minmax(0,1fr)]">
                                    <aside class="space-y-4">
                                        <div class="border-4 border-slate-900 bg-white p-5 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                            <div class="flex items-start justify-between gap-3 border-b-2 border-slate-900 pb-3">
                                                <div>
                                                    <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-500">Kirim Pesan</p>
                                                    <h2 class="mt-2 text-2xl font-black text-slate-950">Buat Pesan Baru</h2>
                                                </div>
                                                <div class="border-2 border-slate-900 bg-[#f7ecff] px-3 py-2 text-[10px] font-black uppercase tracking-[0.18em] text-slate-700">Pelamar</div>
                                            </div>

                                            <form method="POST" action="{{ route('messages.store') }}" class="mt-5 space-y-4">
                                                @csrf
                                                <div>
                                                    <label class="mb-2 block text-xs font-black uppercase tracking-[0.14em] text-slate-700">Tujuan</label>
                                                    <select name="receiver_id" class="h-11 w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 text-sm outline-none" required>
                                                        <option value="">Pilih tujuan</option>
                                                        @forelse($recipients as $recipient)
                                                            <option value="{{ $recipient->id }}">{{ $recipient->name }} ({{ ucfirst($recipient->role) }})</option>
                                                        @empty
                                                            <option value="">Tidak ada pelamar tersedia</option>
                                                        @endforelse
                                                    </select>
                                                    @error('receiver_id')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                                </div>
                                                <div>
                                                    <label class="mb-2 block text-xs font-black uppercase tracking-[0.14em] text-slate-700">Subjek</label>
                                                    <input name="subject" type="text" class="h-11 w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 text-sm outline-none" placeholder="Subjek pesan" />
                                                    @error('subject')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                                </div>
                                                <div>
                                                    <label class="mb-2 block text-xs font-black uppercase tracking-[0.14em] text-slate-700">Isi pesan</label>
                                                    <textarea name="body" rows="7" class="w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 py-2 text-sm outline-none" placeholder="Tulis pesan kamu" required></textarea>
                                                    @error('body')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                                </div>
                                                <button type="submit" class="w-full border-2 border-slate-900 bg-[#5cf47a] px-4 py-3 text-sm font-black uppercase tracking-[0.16em] text-slate-950 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Kirim Pesan</button>
                                            </form>
                                        </div>

                                        <div class="border-4 border-slate-900 bg-black p-5 text-white shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                            <p class="text-xs font-black uppercase tracking-[0.2em] text-[#5cf47a]">Info</p>
                                            <p class="mt-3 text-sm leading-7 text-white/80">Pesan perusahaan hanya bisa dikirim ke akun pelamar agar alur komunikasi tetap fokus ke rekrutmen.</p>
                                        </div>
                                    </aside>

                                    <section id="riwayat-pesan" class="space-y-5">
                                        <div class="border-4 border-slate-900 bg-white p-5 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                            <div class="flex items-start justify-between gap-4">
                                                <div>
                                                    <h2 class="text-2xl font-black text-slate-950">Percakapan</h2>
                                                    <p class="mt-1 text-sm text-slate-600">Pesan masuk dan keluar ditampilkan di sini.</p>
                                                </div>
                                                <a href="{{ route('perusahaan.dashboard') }}" class="border-2 border-slate-900 bg-white px-3 py-2 text-[11px] font-black uppercase tracking-[0.18em] text-slate-900">Dashboard</a>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            @forelse($messages as $message)
                                                @php
                                                    $isIncoming = $message->receiver_id === auth()->id();
                                                @endphp
                                                <article class="border-4 border-slate-900 p-5 shadow-[5px_5px_0_rgba(0,0,0,0.2)] {{ $isIncoming ? 'bg-[#ecfff0]' : 'bg-[#f7ecff]' }}">
                                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                                        <div>
                                                            <div class="text-[10px] font-black uppercase tracking-[0.2em] {{ $isIncoming ? 'text-green-700' : 'text-violet-700' }}">
                                                                {{ $isIncoming ? 'Dari' : 'Ke' }}
                                                            </div>
                                                            <h3 class="mt-1 text-lg font-black text-slate-950">
                                                                {{ $isIncoming ? optional($message->sender)->name : optional($message->receiver)->name }}
                                                            </h3>
                                                            @if($message->subject)
                                                                <p class="mt-1 text-sm font-semibold text-slate-700">{{ $message->subject }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-xs font-semibold text-slate-500">
                                                            {{ $message->created_at->format('d M Y H:i') }}
                                                            @if($isIncoming && !$message->is_read)
                                                                <span class="ml-2 inline-flex border-2 border-slate-900 bg-[#5cf47a] px-2 py-1 font-black text-slate-950">Baru</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <p class="mt-4 text-sm leading-7 text-slate-800">{{ $message->body }}</p>
                                                </article>
                                            @empty
                                                <div class="border-4 border-slate-900 bg-white p-5 text-sm text-slate-600 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">Belum ada pesan.</div>
                                            @endforelse
                                        </div>

                                        <div class="pt-2">{{ $messages->links() }}</div>
                                    </section>
                                </div>
                            </div>
                        </section>
                    </div>
                @else
                    <main class="min-h-screen">
                        <header class="border-b-2 border-black bg-white shadow-[0_2px_0_rgba(0,0,0,0.08)]">
                            <div class="mx-auto flex max-w-[1680px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
                                <a href="{{ url('/') }}" class="text-2xl font-black tracking-tight text-slate-950">NextStep</a>
                                <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-900 lg:flex">
                                    @auth
                                        <a href="{{ auth()->user()->role === 'pelamar' ? route('pelamar.dashboard') : (auth()->user()->role === 'perusahaan' ? route('perusahaan.dashboard') : route('admin.alumni.index')) }}" class="transition hover:underline">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="transition hover:underline">Dashboard</a>
                                    @endauth
                                    @auth
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('admin.alumni.index') }}" class="transition hover:underline">Tracking Alumni</a>
                                        @endif
                                    @endauth
                                    <a href="{{ url('/lowongan') }}" class="transition hover:underline">Cari Lowongan</a>
                                    <a href="#riwayat-pesan" class="transition hover:underline">Riwayat</a>
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
                            @if (session('success'))
                                <div class="mb-5 border-2 border-black bg-[#62f26f] px-4 py-3 text-sm font-bold text-slate-950 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <section class="rounded-none border-2 border-black bg-[#62f26f] px-6 py-6 shadow-[4px_4px_0_rgba(0,0,0,0.12)] sm:px-8">
                                <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-900">Pesan</p>
                                <h1 class="mt-2 text-3xl font-black leading-tight text-slate-950 sm:text-5xl">Inbox dan kirim pesan</h1>
                                <p class="mt-2 max-w-3xl text-sm text-slate-900 sm:text-base">Kirim pesan ke akun dengan role lawan, lalu lihat semua percakapan di satu halaman.</p>
                            </section>

                            <section class="mt-5 grid gap-5 lg:grid-cols-[360px_1fr]">
                                <aside class="space-y-4">
                                    <div class="border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                        <h2 class="text-2xl font-black text-slate-950">Kirim Pesan</h2>
                                        <form method="POST" action="{{ route('messages.store') }}" class="mt-4 space-y-4">
                                            @csrf
                                            <div>
                                                <label class="mb-2 block text-xs font-black uppercase tracking-[0.14em] text-slate-700">Tujuan</label>
                                                <select name="receiver_id" class="h-11 w-full border-2 border-black bg-[#f3f3f3] px-3 text-sm outline-none" required>
                                                    <option value="">Pilih tujuan</option>
                                                    @foreach($recipients as $recipient)
                                                        <option value="{{ $recipient->id }}">{{ $recipient->name }} ({{ ucfirst($recipient->role) }})</option>
                                                    @endforeach
                                                </select>
                                                @error('receiver_id')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                            </div>
                                            <div>
                                                <label class="mb-2 block text-xs font-black uppercase tracking-[0.14em] text-slate-700">Subjek</label>
                                                <input name="subject" type="text" class="h-11 w-full border-2 border-black bg-[#f3f3f3] px-3 text-sm outline-none" placeholder="Subjek pesan" />
                                                @error('subject')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                            </div>
                                            <div>
                                                <label class="mb-2 block text-xs font-black uppercase tracking-[0.14em] text-slate-700">Isi pesan</label>
                                                <textarea name="body" rows="6" class="w-full border-2 border-black bg-[#f3f3f3] px-3 py-2 text-sm outline-none" placeholder="Tulis pesan kamu" required></textarea>
                                                @error('body')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                            </div>
                                            <button type="submit" class="w-full border-2 border-black bg-[#5cf47a] px-4 py-3 text-sm font-black uppercase text-slate-950">Kirim Pesan</button>
                                        </form>
                                    </div>
                                </aside>

                                <section id="riwayat-pesan" class="space-y-4">
                                    <div class="border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                        <h2 class="text-2xl font-black text-slate-950">Percakapan</h2>
                                        <p class="mt-1 text-sm text-slate-600">Pesan masuk dan keluar ditampilkan di sini.</p>
                                    </div>

                                    <div class="space-y-4">
                                        @forelse($messages as $message)
                                            @php
                                                $isIncoming = $message->receiver_id === auth()->id();
                                            @endphp
                                                <article class="border-2 border-black p-4 shadow-[4px_4px_0_rgba(0,0,0,0.12)] {{ $isIncoming ? 'bg-[#ecfff0]' : 'bg-[#f7ecff]' }}">
                                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                                    <div>
                                                            <div class="text-xs font-black uppercase tracking-[0.16em] {{ $isIncoming ? 'text-green-700' : 'text-violet-700' }}">
                                                            {{ $isIncoming ? 'Dari' : 'Ke' }}
                                                        </div>
                                                        <h3 class="text-lg font-black text-slate-950">
                                                            {{ $isIncoming ? optional($message->sender)->name : optional($message->receiver)->name }}
                                                        </h3>
                                                        @if($message->subject)
                                                            <p class="mt-1 text-sm font-semibold text-slate-700">{{ $message->subject }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs font-semibold text-slate-500">
                                                        {{ $message->created_at->format('d M Y H:i') }}
                                                        @if($isIncoming && !$message->is_read)
                                                            <span class="ml-2 inline-flex border-2 border-black bg-[#5cf47a] px-2 py-1 font-black text-slate-950">Baru</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="mt-4 text-sm leading-7 text-slate-800">{{ $message->body }}</p>
                                            </article>
                                        @empty
                                            <div class="border-2 border-black bg-white p-5 text-sm text-slate-600 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Belum ada pesan.</div>
                                        @endforelse
                                    </div>

                                    <div class="pt-2">{{ $messages->links() }}</div>
                                </section>
                            </section>
                        </div>
                    </main>
                @endif
            </main>
        </body>
    </html>