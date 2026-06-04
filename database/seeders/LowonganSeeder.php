<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lowongan;

class LowonganSeeder extends Seeder
{
    public function run(): void
    {
        Lowongan::create([
            'title' => 'Senior Developer',
            'company' => 'Gojek',
            'location' => 'Jakarta, Indonesia',
            'type' => 'Full-time',
            'seniority' => 'Senior',
            'salary_range' => 'Rp 20jt - 40jt',
            'description' => 'Bertanggung jawab membangun sistem backend & layanan skala besar.',
            'requirements' => "Memiliki pengalaman 5+ tahun\nMenguasai PHP & Laravel\nBerpengalaman dengan arsitektur microservices",
            'is_featured' => true,
        ]);

        Lowongan::create([
            'title' => 'Product Designer',
            'company' => 'Tokopedia',
            'location' => 'Remote',
            'type' => 'Full-time',
            'seniority' => 'Mid-Level',
            'salary_range' => 'Rp 15jt - 28jt',
            'description' => 'Bekerja sama dengan tim produk untuk merancang pengalaman pengguna.',
            'requirements' => "Familiar dengan Figma\nMemahami prinsip desain responsif\nMampu membuat prototype cepat",
            'is_featured' => false,
        ]);

        Lowongan::create([
            'title' => 'Marketing Intern',
            'company' => 'Bukalapak',
            'location' => 'Bandung, Indonesia',
            'type' => 'Intern',
            'seniority' => 'Intern',
            'salary_range' => 'Rp 2jt - 4jt',
            'description' => 'Dukungan tim marketing untuk kampanye sosial dan partnership.',
            'requirements' => "Sedang menempuh pendidikan terkait\nMemiliki minat di marketing digital",
            'is_featured' => false,
        ]);

        Lowongan::create([
            'title' => 'Data Analyst',
            'company' => 'Shopee',
            'location' => 'Jakarta, Indonesia',
            'type' => 'Full-time',
            'seniority' => 'Junior',
            'salary_range' => 'Rp 6jt - 12jt',
            'description' => 'Analisis data untuk meningkatkan performa produk.',
            'requirements' => "Menguasai SQL\nPengalaman dengan tools BI\nMemiliki kemampuan statistik dasar",
            'is_featured' => false,
        ]);
    }
}
