<aside class="fixed left-0 top-0 h-screen w-60 flex flex-col border-r-2 border-slate-900 bg-white px-4 py-5 overflow-y-auto">
    <a href="{{ url('/') }}" class="mb-6 block text-xl font-black tracking-tight text-slate-950">NextStep</a>

    <div class="space-y-3">
        <a href="{{ route('perusahaan.dashboard') }}" class="{{ 'flex items-center gap-3 border-4 border-slate-900 px-3 py-3 text-[11px] font-black uppercase tracking-[0.2em] shadow-[4px_4px_0_rgba(0,0,0,0.25)] ' . ((($active ?? '') === 'dashboard') ? 'bg-[#5cf47a]' : 'bg-white') }}">
            <span class="inline-flex h-4 w-4 items-center justify-center bg-slate-900 text-[10px] text-white">▣</span>
            Dashboard
        </a>
        <a href="{{ route('perusahaan.lowongans') }}" class="{{ 'flex items-center gap-3 border-4 border-slate-900 px-3 py-3 text-[11px] font-black uppercase tracking-[0.2em] shadow-[4px_4px_0_rgba(0,0,0,0.25)] ' . ((($active ?? '') === 'lowongans') ? 'bg-[#5cf47a]' : 'bg-white') }}">
            <span class="inline-flex h-4 w-4 items-center justify-center bg-slate-900 text-[10px] text-white">▤</span>
            Lowongan Saya
        </a>
        <a href="{{ route('perusahaan.pelamar') }}" class="{{ 'flex items-center gap-3 border-4 border-slate-900 px-3 py-3 text-[11px] font-black uppercase tracking-[0.2em] shadow-[4px_4px_0_rgba(0,0,0,0.25)] ' . ((($active ?? '') === 'pelamar') ? 'bg-[#5cf47a]' : 'bg-white') }}">
            <span class="inline-flex h-4 w-4 items-center justify-center bg-slate-900 text-[10px] text-white">✚</span>
            Pelamar
        </a>
        <a href="{{ route('messages.index') }}" class="{{ 'flex items-center gap-3 border-4 border-slate-900 px-3 py-3 text-[11px] font-black uppercase tracking-[0.2em] shadow-[4px_4px_0_rgba(0,0,0,0.25)] ' . ((($active ?? '') === 'messages') ? 'bg-[#5cf47a]' : 'bg-white') }}">
            <span class="inline-flex h-4 w-4 items-center justify-center bg-slate-900 text-[10px] text-white">✉</span>
            Pesan
        </a>
        <a href="{{ route('perusahaan.profile.edit') }}" class="{{ 'flex items-center gap-3 border-4 border-slate-900 px-3 py-3 text-[11px] font-black uppercase tracking-[0.2em] shadow-[4px_4px_0_rgba(0,0,0,0.25)] ' . ((($active ?? '') === 'profile') ? 'bg-[#5cf47a]' : 'bg-white') }}">
            <span class="inline-flex h-4 w-4 items-center justify-center bg-slate-900 text-[10px] text-white">⚙</span>
            Profil
        </a>
    </div>

    <div class="mt-auto pt-8">
        <div class="border-t-2 border-slate-900 pt-6">
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="block w-full border-4 border-slate-900 bg-[#ffd6d3] px-4 py-3 text-center text-xs font-black uppercase tracking-[0.2em] text-rose-700 shadow-[4px_4px_0_rgba(0,0,0,0.25)]">Keluar</button>
            </form>
        </div>
    </div>
</aside>
