<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Profil Pelamar - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f3f3f3] text-slate-950">
        <main class="min-h-screen">
            <header class="border-b-2 border-black bg-white shadow-[0_2px_0_rgba(0,0,0,0.08)]">
                <div class="mx-auto flex max-w-[1680px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
                    <a href="{{ url('/') }}" class="text-2xl font-black tracking-tight text-slate-950">NextStep</a>
                    <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-900 lg:flex">
                        <a href="{{ url('/lowongan') }}" class="transition hover:underline">Cari Lowongan</a>
                           @auth
                               <a href="{{ route('pelamar.dashboard') }}" class="transition hover:underline">Dashboard</a>
                           @else
                               <a href="{{ route('login') }}" class="transition hover:underline">Dashboard</a>
                           @endauth
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
                            <h1 class="text-3xl font-black leading-tight text-slate-950 sm:text-5xl">Edit Profil</h1>
                            <p class="mt-2 max-w-2xl text-sm text-slate-900 sm:text-base">Sesuaikan data akunmu agar tetap rapi dan mudah dipakai saat melamar kerja.</p>
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
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <p class="mt-3 text-sm font-black text-slate-950">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-700">Pelamar</p>
                        </div>

                        <nav class="space-y-3">
                            <a href="{{ route('pelamar.dashboard') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">▣</span>
                                Dashboard
                            </a>
                            <a href="{{ route('pelamar.profile.edit') }}" class="flex items-center gap-3 border-2 border-black bg-[#62f26f] px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                                <span class="inline-flex h-5 w-5 items-center justify-center text-xs">◫</span>
                                Profil
                            </a>
                            <a href="{{ route('pelamar.riwayat') }}" class="flex items-center gap-3 border-2 border-black bg-white px-4 py-3 text-sm font-semibold shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
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
                        @if(session('success'))
                            <div class="border-2 border-black bg-[#f7ecff] px-4 py-3 text-sm font-medium text-slate-950 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">{{ session('success') }}</div>
                        @endif

                        <section class="border-2 border-black bg-white p-5 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-2xl font-black text-slate-950">Data Profil</h2>
                                    <p class="mt-1 text-xs text-slate-600">Perbarui informasi utama akunmu di sini.</p>
                                </div>
                                <div class="rounded-none border-2 border-black bg-[#f7ecff] px-4 py-3 text-right shadow-[3px_3px_0_rgba(0,0,0,0.12)]">
                                    <div class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-700">Kelengkapan</div>
                                    <div class="text-2xl font-black text-[#a245ff]">{{ $profileCompleteness }}%</div>
                                </div>
                            </div>

                            <div class="mt-4 h-3 overflow-hidden border-2 border-black bg-[#f3f3f3]">
                                <div class="h-full bg-[#62f26f]" style="width: {{ $profileCompleteness }}%"></div>
                            </div>

                            <form action="{{ route('pelamar.profile.update') }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Foto Profil</label>
                                    <input name="profile_photo" type="file" accept="image/*" class="mt-2 block w-full cursor-pointer border-2 border-black bg-[#f8f8f8] px-3 py-2 text-sm text-slate-950 file:mr-4 file:border-0 file:bg-[#62f26f] file:px-4 file:py-2 file:text-xs file:font-black file:text-slate-950">
                                    <p class="mt-2 text-xs text-slate-500">Format JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Nama Lengkap</label>
                                        <input name="name" type="text" value="{{ old('name', $user->name) }}" class="mt-2 h-11 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Email</label>
                                        <input name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-2 h-11 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                    </div>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">NIM</label>
                                        <input name="nim" type="text" value="{{ old('nim', $user->nim) }}" class="mt-2 h-11 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" placeholder="Contoh: 2210112345" />
                                    </div>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Nomor HP</label>
                                        <input name="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}" class="mt-2 h-11 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" placeholder="08xxxxxxxxxx" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Tanggal Lahir</label>
                                        <input name="birth_date" type="date" value="{{ old('birth_date', $user->birth_date) }}" class="mt-2 h-11 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                    </div>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Kota / Domisili</label>
                                        <input name="city" type="text" value="{{ old('city', $user->city) }}" class="mt-2 h-11 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Jenis Kelamin</label>
                                        <select name="gender" class="mt-2 h-11 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white">
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="male" @selected(old('gender', $user->gender) === 'male')>Laki-laki</option>
                                            <option value="female" @selected(old('gender', $user->gender) === 'female')>Perempuan</option>
                                            <option value="other" @selected(old('gender', $user->gender) === 'other')>Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Alamat Lengkap</label>
                                    <textarea name="address" rows="4" class="mt-2 w-full border-2 border-black bg-[#f8f8f8] px-3 py-3 text-sm text-slate-950 outline-none focus:bg-white">{{ old('address', $user->address) }}</textarea>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Ganti Kata Sandi</label>
                                        <input name="password" type="password" class="mt-2 h-11 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Konfirmasi Kata Sandi</label>
                                        <input name="password_confirmation" type="password" class="mt-2 h-11 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-3 pt-2">
                                    <button class="border-2 border-black bg-[#62f26f] px-4 py-3 text-sm font-black text-slate-950 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Simpan</button>
                                    <a href="{{ route('pelamar.dashboard') }}" class="border-2 border-black bg-white px-4 py-3 text-sm font-black text-slate-950 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Batal</a>
                                </div>
                            </form>
                        </section>
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
