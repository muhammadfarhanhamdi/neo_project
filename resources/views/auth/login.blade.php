<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Masuk - NextStep</title>
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
                            Portal Pelamar
                        </div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-slate-700 sm:text-xs sm:tracking-[0.38em]">NextStep</p>
                        <h1 class="mt-3 max-w-lg text-3xl font-black uppercase leading-[0.95] tracking-tight text-slate-950 sm:mt-4 sm:text-4xl xl:text-5xl">
                            Masuk untuk lanjut mencari kerja
                        </h1>
                        <p class="mt-3 max-w-lg text-sm leading-6 text-slate-700 sm:mt-4 sm:text-base sm:leading-7">
                            Kelola profil, simpan lowongan favorit, dan pantau status lamaran dari satu tempat yang sederhana.
                        </p>

                        <div class="mt-5 grid gap-3 sm:mt-6 sm:gap-4 sm:grid-cols-2">
                            <div class="rounded-[2px] border-4 border-slate-900 bg-white px-4 py-3 shadow-[6px_6px_0_rgba(15,23,42,0.18)]">
                                <p class="text-2xl font-black text-slate-950">500k+</p>
                                <p class="mt-1 text-xs font-bold uppercase tracking-[0.2em] text-slate-600">Talenta aktif</p>
                            </div>
                            <div class="rounded-[2px] border-4 border-slate-900 bg-[#5cf47a] px-4 py-3 shadow-[6px_6px_0_rgba(15,23,42,0.18)]">
                                <p class="text-2xl font-black text-slate-950">24 jam</p>
                                <p class="mt-1 text-xs font-bold uppercase tracking-[0.2em] text-slate-700">Rata-rata respon</p>
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
                                    <p class="text-xs font-black uppercase tracking-[0.36em] text-slate-500">Masuk Akun</p>
                                    <h2 class="mt-2 text-2xl font-black text-slate-950 sm:text-3xl">Selamat datang kembali</h2>
                                    <p data-role-desc class="mt-2 text-sm leading-6 text-slate-600">Masuk untuk melanjutkan aktivitas pelamar.</p>
                                </div>
                                <a href="{{ url('/') }}" class="rounded-[2px] border-2 border-slate-900 px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-slate-950 shadow-[4px_4px_0_rgba(15,23,42,0.16)] transition hover:-translate-y-0.5">Kembali</a>
                            </div>

                            <form id="login-role-form" method="POST" action="{{ route('login.post') }}" class="mt-6 space-y-4">
                                @csrf
                                <div class="grid grid-cols-3 overflow-hidden rounded-[2px] border-2 border-slate-900">
                                    <button type="button" data-role-option="pelamar" class="role-option border-r-2 border-slate-900 bg-[#5cf47a] px-3 py-3 text-sm font-black text-slate-950">Pelamar</button>
                                    <button type="button" data-role-option="perusahaan" class="role-option border-r-2 border-slate-900 bg-white px-3 py-3 text-sm font-black text-slate-500">Perusahaan</button>
                                    <button type="button" data-role-option="admin" class="role-option bg-white px-3 py-3 text-sm font-black text-slate-500">Admin</button>
                                </div>
                                <input type="hidden" name="role" value="pelamar" data-role-input>
                                <div>
                                    <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.3em] text-slate-500">Email</label>
                                    <input name="email" type="email" placeholder="nama@email.com" class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none transition placeholder:text-slate-400 focus:bg-slate-50" required />
                                </div>
                                <div>
                                    <label class="mb-2 block text-[11px] font-black uppercase tracking-[0.3em] text-slate-500">Kata Sandi</label>
                                    <input name="password" type="password" placeholder="••••••••" class="h-12 w-full rounded-[2px] border-2 border-slate-900 bg-white px-4 text-sm outline-none transition placeholder:text-slate-400 focus:bg-slate-50" required />
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-3 text-sm text-slate-600">
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" class="h-4 w-4 rounded border-slate-400 text-slate-950 focus:ring-slate-950" />
                                        Ingat saya
                                    </label>
                                    <a href="{{ route('help.password') }}" class="font-bold text-[#7c3aed] hover:underline">Lupa?</a>
                                </div>
                                <button type="submit" data-role-submit class="flex h-12 w-full items-center justify-center rounded-[2px] border-2 border-slate-900 bg-[#5cf47a] text-sm font-black uppercase tracking-[0.24em] text-slate-950 shadow-[6px_6px_0_rgba(15,23,42,0.16)] transition hover:-translate-y-0.5">
                                    Masuk Sekarang
                                </button>
                            </form>

                            <div class="my-5 h-px bg-slate-200"></div>

                            <div class="flex items-center gap-3 text-xs font-black uppercase tracking-[0.2em] text-slate-500">
                                <div class="h-[2px] flex-1 bg-slate-900/60"></div>
                                <span>Atau</span>
                                <div class="h-[2px] flex-1 bg-slate-900/60"></div>
                            </div>

                            <div class="mt-5 grid grid-cols-2 gap-4">
                                <button type="button" class="flex h-12 items-center justify-center rounded-[2px] border-2 border-slate-900 bg-white text-xs font-bold text-slate-600 transition hover:bg-slate-50">Google</button>
                                <button type="button" class="flex h-12 items-center justify-center rounded-[2px] border-2 border-slate-900 bg-white text-xs font-bold text-slate-600 transition hover:bg-slate-50">Facebook</button>
                            </div>

                            <p class="mt-6 text-center text-sm leading-6 text-slate-600">
                                Belum punya akun?
                                <a href="{{ url('/register') }}" class="font-bold text-[#7c3aed] hover:underline">Daftar</a>
                            </p>
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
                const roleDesc = document.querySelector('[data-role-desc]');
                const roleSubmit = document.querySelector('[data-role-submit]');
                const loginRoleForm = document.getElementById('login-role-form');

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
                        roleDesc.textContent = 'Masuk untuk mengelola lowongan dan kandidat perusahaan.';
                        roleSubmit.textContent = 'Masuk Sebagai Perusahaan';
                    } else if (role === 'admin') {
                        roleBadge.textContent = 'Portal Admin';
                        roleDesc.textContent = 'Masuk untuk tracking alumni kampus berdasarkan NIM.';
                        roleSubmit.textContent = 'Masuk Sebagai Admin';
                    } else {
                        roleBadge.textContent = 'Portal Pelamar';
                        roleDesc.textContent = 'Masuk untuk melanjutkan aktivitas pelamar.';
                        roleSubmit.textContent = 'Masuk Sekarang';
                    }
                }

                roleButtons.forEach((button) => {
                    button.addEventListener('click', function () {
                        setRole(button.dataset.roleOption);
                    });
                });

                const roleFromQuery = new URLSearchParams(window.location.search).get('role');
                if (roleFromQuery === 'pelamar' || roleFromQuery === 'perusahaan' || roleFromQuery === 'admin') {
                    setRole(roleFromQuery);
                }

                // let the form submit normally; JS only handles role selection
            });
        </script>
    </body>
</html>
