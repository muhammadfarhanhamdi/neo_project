<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        .title { font-size: 22px; font-weight: 700; margin-bottom: 6px; }
        .meta { font-size: 11px; color: #4b5563; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #111827; padding: 8px 6px; vertical-align: top; }
        th { background: #111827; color: #fff; font-size: 11px; text-transform: uppercase; }
        .badge { display: inline-block; padding: 3px 8px; border: 1px solid #111827; font-size: 10px; font-weight: 700; }
        .yes { background: #62f26f; }
        .no { background: #ffd6d3; }
    </style>
</head>
<body>
    <div class="title">Laporan Tracking Alumni</div>
    <div class="meta">
        Filter NIM: {{ $filters['nim'] ?: '-' }} | Status: {{ $filters['status'] }} | Dicetak: {{ $generatedAt->format('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status Kerja</th>
                <th>Perusahaan</th>
                <th>Posisi</th>
                <th>Total Lamaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alumni as $index => $item)
                @php
                    $accepted = $item->applications->firstWhere('status', 'accepted');
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nim }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <span class="badge {{ $accepted ? 'yes' : 'no' }}">{{ $accepted ? 'Sudah Diterima' : 'Belum Diterima' }}</span>
                    </td>
                    <td>{{ $accepted && $accepted->lowongan ? $accepted->lowongan->company : '-' }}</td>
                    <td>{{ $accepted && $accepted->lowongan ? $accepted->lowongan->title : '-' }}</td>
                    <td>{{ $item->applications->count() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Data alumni tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
