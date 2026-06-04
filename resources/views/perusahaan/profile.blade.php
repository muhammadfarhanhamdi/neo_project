<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Profil Perusahaan - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-slate-950 pl-60">
        <main class="min-h-screen">
            <div class="mx-auto w-full max-w-[1680px]">
                @include('perusahaan.sidebar', ['active' => 'profile'])

                <section class="border-l-2 border-slate-900 bg-white">
                    <header class="border-b-2 border-slate-900 bg-white">
                        <div class="flex items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
                            <div class="ml-auto text-[13px] font-black uppercase tracking-[0.14em] text-slate-900">
                                {{ auth()->user()->name }}
                            </div>
                            <a href="{{ route('perusahaan.dashboard') }}" class="border-2 border-slate-900 bg-white px-3 py-2 text-[11px] font-black uppercase tracking-[0.18em] text-slate-900">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="border-2 border-slate-900 bg-[#ffd6d3] px-3 py-2 text-[11px] font-black uppercase tracking-[0.18em] text-rose-700">Keluar</button>
                            </form>
                        </div>
                    </header>

                    <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                            <div class="max-w-4xl">
                                <h1 class="text-4xl font-black uppercase leading-[0.92] sm:text-5xl">Edit<br>Profil Perusahaan</h1>
                                <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-700 sm:text-base">Perbarui identitas akun perusahaan agar informasi yang tampil di dashboard dan lowongan tetap rapi.</p>
                            </div>

                            <div class="border-4 border-slate-900 bg-[#61f275] p-5 shadow-[6px_6px_0_rgba(0,0,0,0.28)]">
                                <div class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-800">Kelengkapan Profil</div>
                                <div class="mt-1 text-5xl font-black leading-none">{{ $profileCompleteness }}%</div>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="mt-5 border-2 border-green-900 bg-green-100 px-4 py-3 text-sm font-semibold text-green-800">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mt-7 grid gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
                            <aside class="space-y-4">
                                <div class="border-4 border-slate-900 bg-white p-5 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                    <div class="mx-auto flex h-28 w-28 items-center justify-center overflow-hidden border-4 border-slate-900 bg-[#ead8ff] text-4xl font-black text-slate-950">
                                        @if ($user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto profil {{ $user->name }}" class="h-full w-full object-cover">
                                        @else
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <p class="mt-4 text-center text-lg font-black text-slate-950">{{ $user->name }}</p>
                                    <p class="text-center text-xs font-semibold uppercase tracking-[0.18em] text-slate-600">Akun Perusahaan</p>
                                </div>

                                <div class="border-4 border-slate-900 bg-black p-5 text-white shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                    <p class="text-xs font-black uppercase tracking-[0.2em] text-[#5cf47a]">Info Singkat</p>
                                    <p class="mt-3 text-sm leading-6 text-white/85">Nama akun dipakai sebagai nama perusahaan di lowongan. Pastikan email aktif dan nomor telepon mudah dihubungi.</p>
                                </div>
                            </aside>

                            <section class="border-4 border-slate-900 bg-white p-5 shadow-[5px_5px_0_rgba(0,0,0,0.2)]">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h2 class="text-2xl font-black uppercase text-slate-950">Data Akun</h2>
                                        <p class="mt-1 text-xs text-slate-600">Edit detail dasar perusahaan di sini.</p>
                                    </div>
                                    <div class="border-2 border-slate-900 bg-[#f7ecff] px-4 py-3 text-right">
                                        <div class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-700">Status</div>
                                        <div class="text-sm font-black text-[#8e36dc]">Aktif</div>
                                    </div>
                                </div>

                                <div class="mt-4 h-3 overflow-hidden border-2 border-slate-900 bg-[#f3f3f3]">
                                    <div class="h-full bg-[#61f275]" style="width: {{ $profileCompleteness }}%"></div>
                                </div>

                                <form action="{{ route('perusahaan.profile.update') }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Foto Profil</label>
                                        <input name="profile_photo" type="file" accept="image/*" class="mt-2 block w-full cursor-pointer border-2 border-slate-900 bg-[#f8f8f8] px-3 py-2 text-sm text-slate-950 file:mr-4 file:border-0 file:bg-[#61f275] file:px-4 file:py-2 file:text-xs file:font-black file:text-slate-950">
                                        <p class="mt-2 text-xs text-slate-500">Format JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                                    </div>

                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Nama Perusahaan</label>
                                            <input name="name" type="text" value="{{ old('name', $user->name) }}" class="mt-2 h-11 w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Email</label>
                                            <input name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-2 h-11 w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                        </div>
                                    </div>

                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Nomor HP</label>
                                            <input name="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}" class="mt-2 h-11 w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" placeholder="08xxxxxxxxxx" />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Kota / Domisili</label>
                                            <input name="city" type="text" value="{{ old('city', $user->city) }}" class="mt-2 h-11 w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Alamat Kantor</label>
                                        <textarea name="address" rows="4" class="mt-2 w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 py-3 text-sm text-slate-950 outline-none focus:bg-white">{{ old('address', $user->address) }}</textarea>
                                    </div>

                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Ganti Kata Sandi</label>
                                            <input name="password" type="password" class="mt-2 h-11 w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Konfirmasi Kata Sandi</label>
                                            <input name="password_confirmation" type="password" class="mt-2 h-11 w-full border-2 border-slate-900 bg-[#f8f8f8] px-3 text-sm text-slate-950 outline-none focus:bg-white" />
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-3 pt-2">
                                        <button class="border-2 border-slate-900 bg-[#61f275] px-4 py-3 text-sm font-black text-slate-950 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Simpan</button>
                                        <a href="{{ route('perusahaan.dashboard') }}" class="border-2 border-slate-900 bg-white px-4 py-3 text-sm font-black text-slate-950 shadow-[4px_4px_0_rgba(0,0,0,0.12)]">Batal</a>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>