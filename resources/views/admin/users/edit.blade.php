<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaturan Profil Admin - NextStep</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#f3f3f3] text-slate-950">
<main class="min-h-screen">
    <header class="border-b-2 border-black bg-white">
        <div class="mx-auto flex max-w-[1680px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
            <a href="{{ url('/') }}" class="text-2xl font-black tracking-tight text-slate-950">NextStep</a>
            <a href="{{ route('admin.dashboard') }}" class="border-2 border-black bg-[#62f26f] px-3 py-2 text-xs font-black text-slate-950 shadow-[3px_3px_0_rgba(0,0,0,0.15)]">Kembali ke Dashboard</a>
        </div>
    </header>

    <div class="mx-auto max-w-[980px] px-4 py-6 sm:px-6 lg:px-10 lg:py-8">
        <div class="border-4 border-black bg-white shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
            <div class="border-b-4 border-black bg-[#62f26f] px-5 py-4 text-slate-950">
                <div class="text-xs font-black uppercase tracking-[0.18em]">Pengaturan Profil</div>
                <h1 class="mt-2 text-3xl font-black leading-tight">Atur data akun admin</h1>
            </div>
            <div class="p-5 sm:p-6">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="grid gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Nama</label>
                        <input name="name" value="{{ old('name', $user->name) }}" class="mt-2 h-12 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm font-semibold outline-none focus:bg-white" />
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">NIM</label>
                        <input name="nim" value="{{ old('nim', $user->nim) }}" class="mt-2 h-12 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm font-semibold outline-none focus:bg-white" />
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-[0.16em] text-slate-700">Nomor HP</label>
                        <input name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="mt-2 h-12 w-full border-2 border-black bg-[#f8f8f8] px-3 text-sm font-semibold outline-none focus:bg-white" />
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button class="h-12 border-2 border-black bg-black px-5 text-sm font-black text-white">Simpan Perubahan</button>
                        <a href="{{ route('admin.dashboard') }}" class="h-12 border-2 border-black bg-white px-5 inline-flex items-center text-sm font-black">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>
