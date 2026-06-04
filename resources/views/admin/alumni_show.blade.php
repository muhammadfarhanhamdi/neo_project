<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Alumni</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#f3f3f3] text-slate-950">
<main class="min-h-screen">
    <div class="mx-auto max-w-3xl p-6">
        <div class="border-4 border-black bg-white p-4 shadow-[8px_8px_0_rgba(0,0,0,0.18)]">
            <div class="bg-black px-4 py-2 text-white font-black">Detail Alumni</div>
            <div class="p-4">
                <h2 class="text-xl font-black">{{ $user->name }}</h2>
                <p class="text-sm text-slate-700">NIM: {{ $user->nim ?? '-' }}</p>
                <p class="text-sm text-slate-700">Email: {{ $user->email }}</p>
                <p class="mt-4 text-sm text-slate-700">Total Lamaran: {{ $user->applications->count() }}</p>
                <div class="mt-4">
                    <a href="{{ route('admin.alumni.index') }}" class="inline-block border-2 border-black px-3 py-1 font-black">Kembali</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-block border-2 border-black bg-[#62f26f] px-3 py-1 font-black ml-2">Edit</a>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
