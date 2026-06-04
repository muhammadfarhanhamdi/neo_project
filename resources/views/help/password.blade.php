<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bantuan Masuk - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f3f3f3] text-slate-950">
        <main class="min-h-screen px-4 py-10 sm:px-6 lg:px-10">
            <div class="mx-auto max-w-3xl border-4 border-slate-900 bg-white p-6 shadow-[8px_8px_0_rgba(0,0,0,0.16)] sm:p-8">
                <p class="text-xs font-black uppercase tracking-[0.32em] text-slate-500">Pusat Bantuan</p>
                <h1 class="mt-3 text-3xl font-black uppercase text-slate-950 sm:text-4xl">Bantuan Masuk Akun</h1>
                <p class="mt-4 text-sm leading-7 text-slate-700">
                    Fitur reset kata sandi belum dibuat penuh. Untuk sementara, gunakan akun yang sudah terdaftar atau daftar ulang jika Anda belum punya akses.
                </p>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="border-2 border-slate-900 bg-[#f7ecff] p-4">
                        <h2 class="text-sm font-black uppercase tracking-[0.2em] text-slate-900">Pelamar</h2>
                        <p class="mt-2 text-sm text-slate-700">Masuk dengan email dan kata sandi Anda, lalu buka dashboard pelamar.</p>
                    </div>
                    <div class="border-2 border-slate-900 bg-[#e6f7e8] p-4">
                        <h2 class="text-sm font-black uppercase tracking-[0.2em] text-slate-900">Perusahaan</h2>
                        <p class="mt-2 text-sm text-slate-700">Masuk sebagai perusahaan untuk mengelola profil dan lowongan.</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="border-2 border-slate-900 bg-slate-950 px-4 py-3 text-sm font-black uppercase tracking-[0.18em] text-white">Ke Login</a>
                    <a href="{{ route('register') }}" class="border-2 border-slate-900 bg-white px-4 py-3 text-sm font-black uppercase tracking-[0.18em] text-slate-950">Ke Register</a>
                    <a href="{{ url('/') }}" class="border-2 border-slate-900 bg-[#62f26f] px-4 py-3 text-sm font-black uppercase tracking-[0.18em] text-slate-950">Beranda</a>
                </div>
            </div>
        </main>
    </body>
</html>