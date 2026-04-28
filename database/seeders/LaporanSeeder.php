<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->warn('Tidak ada user di database. Lewati LaporanSeeder.');
            return;
        }

        $statuses = ['menunggu', 'diverifikasi', 'diproses', 'selesai', 'ditolak'];

        $samples = [
            ['judul' => 'Tumpukan sampah di pinggir jalan',           'lokasi' => 'Jl. Merdeka No. 12, Jakarta Pusat',     'deskripsi' => 'Tumpukan sampah rumah tangga sudah menggunung selama 3 hari dan menimbulkan bau tidak sedap.'],
            ['judul' => 'Sampah plastik mencemari sungai',            'lokasi' => 'Sungai Ciliwung, Bidara Cina',          'deskripsi' => 'Banyak sampah plastik mengapung di sepanjang aliran sungai, terutama setelah hujan deras.'],
            ['judul' => 'Tempat sampah umum penuh dan rusak',         'lokasi' => 'Taman Suropati, Menteng',               'deskripsi' => 'Tempat sampah di taman sudah penuh sejak akhir pekan dan tutupnya rusak sehingga sampah berserakan.'],
            ['judul' => 'Pembakaran sampah liar di lahan kosong',     'lokasi' => 'Jl. Kebon Jeruk Raya, Jakarta Barat',   'deskripsi' => 'Warga membakar sampah di lahan kosong sehingga asap mengganggu pernapasan tetangga sekitar.'],
            ['judul' => 'Sampah menumpuk di trotoar',                 'lokasi' => 'Jl. Sudirman, Bundaran HI',             'deskripsi' => 'Sampah menumpuk di trotoar dan menghalangi jalur pejalan kaki, terutama pada pagi hari.'],
            ['judul' => 'TPS liar di sekitar perumahan',              'lokasi' => 'Perumahan Griya Asri, Bekasi',          'deskripsi' => 'Muncul tempat pembuangan sementara liar di pojok kompleks yang dijadikan warga sekitar untuk membuang sampah.'],
            ['judul' => 'Limbah konstruksi dibuang sembarangan',      'lokasi' => 'Jl. Pemuda, Rawamangun',                'deskripsi' => 'Sisa material bangunan seperti pecahan keramik dan semen dibuang di pinggir jalan tanpa izin.'],
            ['judul' => 'Saluran air tersumbat sampah daun',          'lokasi' => 'Jl. Cikini Raya',                       'deskripsi' => 'Got di sepanjang jalan tersumbat sampah daun dan plastik, menyebabkan genangan saat hujan.'],
            ['judul' => 'Sampah pasar berserakan di pagi hari',       'lokasi' => 'Pasar Senen Blok III',                  'deskripsi' => 'Sisa sampah dari aktivitas pasar belum diangkut sehingga berserakan dan menarik lalat serta tikus.'],
            ['judul' => 'Tumpukan kardus bekas di gang sempit',       'lokasi' => 'Gang Mawar, Tanah Abang',               'deskripsi' => 'Tumpukan kardus bekas mempersempit akses jalan warga dan rawan terbakar saat musim kemarau.'],
            ['judul' => 'Sampah elektronik dibuang di sungai kecil',  'lokasi' => 'Kali Pesanggrahan, Cipulir',            'deskripsi' => 'Beberapa unit barang elektronik bekas seperti TV dan kipas angin ditemukan dibuang ke aliran kali.'],
            ['judul' => 'Tempat sampah hilang dari halte bus',        'lokasi' => 'Halte Tosari, Jakarta Pusat',           'deskripsi' => 'Tempat sampah di halte bus sudah lama tidak tersedia sehingga penumpang membuang sampah sembarangan.'],
            ['judul' => 'Limbah dapur restoran mengotori jalan',      'lokasi' => 'Jl. Sabang, Jakarta Pusat',             'deskripsi' => 'Limbah dapur dari beberapa restoran sering tumpah ke jalan dan menimbulkan bau menyengat.'],
            ['judul' => 'Sampah popok bayi di taman bermain',         'lokasi' => 'Taman RPTRA Kalijodo',                  'deskripsi' => 'Banyak ditemukan popok bayi bekas yang dibuang sembarangan di area taman bermain anak.'],
            ['judul' => 'Sampah daun kering menumpuk berbulan-bulan', 'lokasi' => 'Jl. Diponegoro, Menteng',               'deskripsi' => 'Sampah daun kering hasil pemangkasan pohon belum diangkut petugas selama beberapa bulan.'],
        ];

        foreach ($samples as $i => $sample) {
            Laporan::create([
                'user_id'    => $user->id,
                'petugas_id' => null,
                'judul'      => $sample['judul'],
                'deskripsi'  => $sample['deskripsi'],
                'lokasi'     => $sample['lokasi'],
                'status'     => $statuses[$i % count($statuses)],
            ]);
        }
    }
}
