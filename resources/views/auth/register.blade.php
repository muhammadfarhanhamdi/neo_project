<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registrasi Perusahaan - NextStep</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f3f3f3] text-slate-950">
        <main class="min-h-screen">
            <header class="sticky top-0 z-30 border-b-4 border-slate-900 bg-white/85 backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-3 lg:px-10">
                    <a href="{{ url('/') }}" class="text-xl font-black tracking-tight text-slate-950">NextStep</a>
                </div>
            </header>

            <div class="grid min-h-[calc(100vh-65px)] lg:grid-cols-[1fr_1fr]">
                <section class="relative flex items-center overflow-hidden border-b border-slate-900/20 bg-[#e7e7e7] px-5 py-6 sm:px-6 lg:border-b-0 lg:border-r lg:px-10">
                    <div class="relative mx-auto w-full max-w-xl">
                        <div data-role-badge class="mb-3 inline-flex rounded-full bg-[#7c3aed] px-4 py-1 text-[11px] font-black uppercase tracking-[0.28em] text-white shadow-[4px_4px_0_rgba(15,23,42,0.9)]">
                            Portal Rekruter
                        </div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-slate-700 sm:text-xs sm:tracking-[0.38em]">NextStep</p>
                        <h1 class="mt-3 max-w-lg text-3xl font-black uppercase leading-[0.95] tracking-tight text-slate-950 sm:mt-4 sm:text-4xl xl:text-5xl">
                            Temukan Talenta Terbaik
                        </h1>
                        <p class="mt-3 max-w-lg text-sm leading-6 text-slate-700 sm:mt-4 sm:text-base sm:leading-7">
                            Bangun tim impian Anda dengan akses ke ribuan profesional berkualitas. Proses cepat, transparan, dan tanpa basa-basi.
                        </p>

                        <div class="mt-5 grid gap-3 sm:mt-6 sm:gap-4 sm:grid-cols-2">
                            <div class="rounded-[2px] border-4 border-slate-900 bg-white px-4 py-3 shadow-[6px_6px_0_rgba(15,23,42,0.18)]">
                                <p class="text-2xl font-black text-slate-950">500k+</p>
                                <p class="mt-1 text-xs font-bold uppercase tracking-[0.2em] text-slate-600">Talenta Aktif</p>
                            </div>
                            <div class="rounded-[2px] border-4 border-slate-900 bg-[#5cf47a] px-4 py-3 shadow-[6px_6px_0_rgba(15,23,42,0.18)]">
                                <p class="text-2xl font-black text-slate-950">24 Jam</p>
                                <p class="mt-1 text-xs font-bold uppercase tracking-[0.2em] text-slate-700">Rata-rata Respon</p>
                            </div>
                        </div>

                        <div class="mt-5 overflow-hidden rounded-[2px] border-4 border-slate-900 bg-white shadow-[6px_6px_0_rgba(15,23,42,0.18)] sm:mt-6">
                            <img src="{{ asset('images/job-vacancy-hero.svg') }}" alt="Ilustrasi lowongan pekerjaan" class="h-[200px] w-full object-cover sm:h-[260px] lg:h-[320px]" />
                        </div>
                    </div>
                </section>

                <section class="flex items-center justify-center bg-[#f7f7f7] px-5 py-6 sm:px-6 lg:px-10">
                    <div class="w-full max-w-xl">
                        <div class="mx-auto w-full max-w-md rounded-[2px] border border-slate-900 bg-white px-5 py-6 shadow-[8px_8px_0_rgba(15,23,42,0.16)] sm:px-6 sm:py-7 lg:px-7">
                            <div class="flex items-start justify-between gap-6">
                                <div>
                                    <p data-role-caption class="text-xs font-black uppercase tracking-[0.36em] text-slate-500">Registrasi Pelamar</p>
                                    <h2 data-role-title class="mt-2 text-2xl font-black text-slate-950 sm:text-3xl">Lengkapi data untuk mulai melamar lowongan.</h2>
                                </div>
                                
                            </div>

                            <form method="POST" action="{{ route('register.post') }}" class="mt-6 space-y-4">
                                @csrf
                                <div class="grid grid-cols-2 overflow-hidden rounded-[2px] border-2 border-slate-900">
                                    <button type="button" data-role-option="pelamar" class="role-option border-r-2 border-slate-900 bg-[#5cf47a] px-3 py-3 text-sm font-black text-slate-950">Pelamar</button>
                                    <button type="button" data-role-option="perusahaan" class="role-option bg-white px-3 py-3 text-sm font-black text-slate-500">Perusahaan</button>
                                </div>
                                <input type="hidden" name="role" value="pelamar" data-role-input>
                                <div>
                                    <label data-role-label-name class="mb-2 block text-[11px] font-black uppercase tracking-[0.3em] text-slate-500">Nama Lengkap</label>
                                    <input name="name" data-role-input-name type="text" placeholder="Nama lengkap Anda" class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none transition placeholder:text-slate-400 focus:bg-slate-50" />
                                </div>
                                <div>
                                    <label data-role-label-email class="mb-2 block text-[11px] font-black uppercase tracking-[0.3em] text-slate-500">Alamat Email</label>
                                    <input name="email" data-role-input-email type="email" placeholder="nama@email.com" class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none transition placeholder:text-slate-400 focus:bg-slate-50" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.3em] text-slate-500">Kata Sandi</label>
                                    <input name="password" type="password" placeholder="••••••••" class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none transition placeholder:text-slate-400 focus:bg-slate-50" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.3em] text-slate-500">Konfirmasi Kata Sandi</label>
                                    <input name="password_confirmation" type="password" placeholder="••••••••" class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none transition placeholder:text-slate-400 focus:bg-slate-50" />
                                </div>
                                <label class="flex items-start gap-3 text-sm leading-6 text-slate-600">
                                    <input type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-400 text-slate-950 focus:ring-slate-950" />
                                    <span>Saya setuju dengan <span class="font-bold text-[#7c3aed]">Syarat &amp; Ketentuan</span> serta <span class="font-bold text-[#7c3aed]">Kebijakan Privasi</span> NextStep.</span>
                                </label>
                                <button type="submit" data-role-submit class="flex h-12 w-full items-center justify-center rounded-[2px] border-2 border-slate-900 bg-[#5cf47a] text-sm font-black uppercase tracking-[0.24em] text-slate-950 shadow-[6px_6px_0_rgba(15,23,42,0.16)] transition hover:-translate-y-0.5">
                                    Daftar Sebagai Pelamar
                                </button>
                            </form>

                            <div class="my-5 h-px bg-slate-200"></div>

                            <p class="text-center text-sm leading-6 text-slate-600">
                                Sudah punya akun?
                                <a href="{{ url('/login') }}" class="font-bold text-[#7c3aed] hover:underline">Masuk di sini</a>
                            </p>

                            <div class="mt-6 text-center">
                                <a href="{{ url('/') }}" class="inline-flex rounded-[2px] border-2 border-slate-900 px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-slate-950 shadow-[4px_4px_0_rgba(15,23,42,0.16)] transition hover:-translate-y-0.5">Kembali ke Beranda</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const roleButtons = document.querySelectorAll('.role-option');
                const roleInput = document.querySelector('[data-role-input]');
                const roleBadge = document.querySelector('[data-role-badge]');
                const roleCaption = document.querySelector('[data-role-caption]');
                const roleTitle = document.querySelector('[data-role-title]');
                const roleLabelName = document.querySelector('[data-role-label-name]');
                const roleLabelEmail = document.querySelector('[data-role-label-email]');
                const roleInputName = document.querySelector('[data-role-input-name]');
                const roleInputEmail = document.querySelector('[data-role-input-email]');
                const roleSubmit = document.querySelector('[data-role-submit]');

                function setRole(role) {
                    roleButtons.forEach((button) => {
                        const active = button.dataset.roleOption === role;
                        button.classList.toggle('bg-[#5cf47a]', active);
                        button.classList.toggle('text-slate-950', active);
                        button.classList.toggle('bg-white', !active);
                        button.classList.toggle('text-slate-500', !active);
                    });

                    roleInput.value = role;

                    if (role === 'perusahaan') {
                        roleBadge.textContent = 'Portal Rekruter';
                        roleCaption.textContent = 'Registrasi Perusahaan';
                        roleTitle.textContent = 'Lengkapi data untuk mulai memasang lowongan.';
                        roleLabelName.textContent = 'Nama Perusahaan';
                        roleInputName.placeholder = 'PT. Teknologi Bangsa';
                        roleLabelEmail.textContent = 'Email Bisnis';
                        roleInputEmail.placeholder = 'hrd@perusahaan.com';
                        roleSubmit.textContent = 'Daftar Sebagai Perusahaan';
                    } else {
                        roleBadge.textContent = 'Portal Pelamar';
                        roleCaption.textContent = 'Registrasi Pelamar';
                        roleTitle.textContent = 'Lengkapi data untuk mulai melamar lowongan.';
                        roleLabelName.textContent = 'Nama Lengkap';
                        roleInputName.placeholder = 'Nama lengkap Anda';
                        roleLabelEmail.textContent = 'Alamat Email';
                        roleInputEmail.placeholder = 'nama@email.com';
                        roleSubmit.textContent = 'Daftar Sebagai Pelamar';
                    }
                }

                roleButtons.forEach((button) => {
                    button.addEventListener('click', function () {
                        setRole(button.dataset.roleOption);
                    });
                });

                const roleFromQuery = new URLSearchParams(window.location.search).get('role');
                if (roleFromQuery === 'perusahaan' || roleFromQuery === 'pelamar') {
                    setRole(roleFromQuery);
                }
            });
        </script>
    </body>
</html>
