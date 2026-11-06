<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Banom;
use App\Models\Category;
use App\Models\Donation;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Member;
use App\Models\OrganizationProfile;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. ROLES & PERMISSIONS
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $pengurusRole = Role::firstOrCreate(['name' => 'pengurus']);

        // 2. USERS
        // Password 'password' hanya dipakai di lingkungan local/testing.
        // Di lingkungan lain (server) dibuat acak dan ditampilkan SEKALI di layar.
        $isDevEnv = app()->environment(['local', 'testing']);
        $adminPassword = $isDevEnv ? 'password' : Str::random(16);
        $pengurusPassword = $isDevEnv ? 'password' : Str::random(16);

        $admin = User::firstOrCreate(
            ['email' => 'admin@nu.or.id'],
            [
                'name' => 'Administrator Ranting Karangtengah',
                'phone' => '081234567890',
                'password' => Hash::make($adminPassword),
                'status' => 'active',
            ]
        );
        $admin->syncRoles([$adminRole]);

        $pengurus = User::firstOrCreate(
            ['email' => 'pengurus@nu.or.id'],
            [
                'name' => 'Sekretaris Ranting Karangtengah',
                'phone' => '081298765432',
                'password' => Hash::make($pengurusPassword),
                'status' => 'active',
            ]
        );
        $pengurus->syncRoles([$pengurusRole]);

        if (! $isDevEnv) {
            if ($admin->wasRecentlyCreated) {
                $this->command?->warn("Password awal admin@nu.or.id: {$adminPassword} (catat, lalu segera ganti)");
            }
            if ($pengurus->wasRecentlyCreated) {
                $this->command?->warn("Password awal pengurus@nu.or.id: {$pengurusPassword} (catat, lalu segera ganti)");
            }
        }

        // 3. PROFIL ORGANISASI
        OrganizationProfile::updateOrCreate(
            ['id' => 1],
            [
                'nama_organisasi' => 'Pengurus Ranting Nahdlatul Ulama Karangtengah',
                'nama_singkat' => 'PRNU Karangtengah',
                'tingkat' => 'Pengurus Ranting',
                'wilayah' => 'Desa Karangtengah, Colongok, Banyumas',
                'tagline' => 'Merawat Jagat, Membangun Peradaban dengan Ahlussunnah Wal Jamaah',
                'tentang' => 'Pengurus Ranting Nahdlatul Ulama (PRNU) Karangtengah adalah institusi keagamaan dan kemasyarakatan Islam yang berkhidmat di tingkat desa/kelurahan, menaungi jamaah dan jam\'iyyah nahdliyin dalam memperkuat akidah Aswaja an-Nahdliyyah, pemberdayaan sosial ekonomi, dan pendidikan umat.',
                'sejarah' => "Nahdlatul Ulama berdiri pada 16 Rajab 1344 H / 31 Januari 1926 M di Surabaya atas inisiasi para ulama pesantren kharismatik Nusantara di bawah Hadratussyaikh KH. M. Hasyim Asy'ari.\n\nDi Desa Karangtengah, cikal bakal penggerak NU telah hadir semenjak masa pergerakan kemerdekaan melalui jejaring santri dan kiai langgar. Secara formal struktural ranting, PRNU Karangtengah terus aktif berkhidmat dari generasi ke generasi menjaga tradisi tahlil, istighotsah, manaqib, yasinan, dan pemberdayaan jamaah.",
                'visi' => 'Terwujudnya tata kehidupan masyarakat Karangtengah yang religius, guyub rukun, mandiri, dan berakhlakul karimah dalam bingkai Ahlussunnah wal Jama\'ah.',
                'misi' => "1. Menjaga dan melestarikan amaliah serta ajaran Aswaja an-Nahdliyyah di seluruh musholla, masjid, dan majelis taklim.\n2. Melaksanakan kaderisasi terstruktur melalui seluruh Badan Otonom (Ansor, Banser, Fatayat, IPNU, IPPNU).\n3. Menggerakkan kemandirian ekonomi umat melalui Kotak Infaq Koin NU (Koin Nahdliyin).\n4. Memberikan pelayanan sosial, keagamaan, dan tanggap darurat bencana bagi masyarakat.",
                'periode' => '2024 - 2029',
                'alamat' => 'Jl. Raya Karangtengah No. 19, Kompleks Masjid Jami\' Al-Huda',
                'kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'kode_pos' => '53165',
                'telepon' => '0281-654321',
                'whatsapp' => '6281234567890',
                'email' => 'sekretariat@prnu-karangtengah.or.id',
                'website' => 'https://prnu-karangtengah.or.id',
                'rekening_bank' => 'Bank Syariah Indonesia (BSI)',
                'nomor_rekening' => '7188-9900-1122',
                'nama_rekening' => 'PRNU KARANGTENGAH INFAQ SOSIAL',
            ]
        );

        // 4. BADAN OTONOM (BANOM)
        $banomData = [
            [
                'nama' => 'Gerakan Pemuda Ansor',
                'slug' => 'gp-ansor',
                'singkatan' => 'GP Ansor',
                'deskripsi' => 'Badan Otonom NU yang membidangi pemuda dan ketahanan generasi muda nahdliyin, benteng para ulama dan NKRI.',
                'ketua' => 'Sahabat M. Ilham Fauzi',
                'kontak' => '0813-2211-4455',
                'alamat' => 'Sekretariat GP Ansor Ranting Karangtengah',
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'nama' => 'Barisan Ansor Serbaguna',
                'slug' => 'banser',
                'singkatan' => 'BANSER',
                'deskripsi' => 'Satuan komando kader inti GP Ansor berdisiplin tinggi, bertugas mengamankan ulama, pesantren, dan kegiatan kemanusiaan.',
                'ketua' => 'Komandan Sugeng Riyadi',
                'kontak' => '0812-4455-6677',
                'alamat' => 'Posko Banser Ranting Karangtengah',
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'nama' => 'Fatayat Nahdlatul Ulama',
                'slug' => 'fatayat-nu',
                'singkatan' => 'Fatayat NU',
                'deskripsi' => 'Badan Otonom NU untuk perempuan muda nahdliyin, fokus pada penguatan keluarga sakinah, pendidikan anak, dan ekonomi perempuan.',
                'ketua' => 'Sahabat Siti Nur Halimah, S.Pd.I',
                'kontak' => '0815-6677-8899',
                'alamat' => 'Gedung Muslimat-Fatayat Ranting Karangtengah',
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'nama' => 'Ikatan Pelajar Nahdlatul Ulama',
                'slug' => 'ipnu',
                'singkatan' => 'IPNU',
                'deskripsi' => 'Wadah kaderisasi pelajar, santri, dan mahasiswa putra nahdliyin di tingkat ranting dalam bingkai 3B: Belajar, Berjuang, Bertaqwa.',
                'ketua' => 'Rekan Bagus Prasetyo',
                'kontak' => '0857-1122-3344',
                'alamat' => 'Sekretariat IPNU Ranting Karangtengah',
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'nama' => 'Ikatan Pelajar Putri Nahdlatul Ulama',
                'slug' => 'ippnu',
                'singkatan' => 'IPPNU',
                'deskripsi' => 'Wadah pembinaan pelajar dan santri putri nahdliyin agar menjadi muslimah yang cerdas, tangguh, dan berakhlak mulia.',
                'ketua' => 'Rekanita Dwi Rahmawati',
                'kontak' => '0858-9900-1122',
                'alamat' => 'Sekretariat IPPNU Ranting Karangtengah',
                'status' => 'active',
                'sort_order' => 5,
            ],
        ];

        $banomModels = [];
        foreach ($banomData as $b) {
            $banomModels[$b['singkatan']] = Banom::updateOrCreate(['slug' => $b['slug']], $b);
        }

        // 5. KATEGORI BERITA
        $categories = [
            ['name' => 'Warta Ranting Karangtengah', 'slug' => 'warta-ranting', 'color' => '#00704A', 'description' => 'Berita kegiatan di lingkungan ranting'],
            ['name' => 'Tausiyah & Opini', 'slug' => 'tausiyah-opini', 'color' => '#C9A227', 'description' => 'Kajian agama, fatwa, dan nasihat para kiai'],
            ['name' => 'Kaderisasi Banom', 'slug' => 'kaderisasi-banom', 'color' => '#2563EB', 'description' => 'Kegiatan Ansor, Banser, Fatayat, IPNU, IPPNU'],
            ['name' => 'Sosial & Koin NU', 'slug' => 'sosial-koin-nu', 'color' => '#DC2626', 'description' => 'Penyaluran infaq, santunan anak yatim, dan kemanusiaan'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 6. ANGGOTA & PENGURUS
        $members = [
            [
                'nis' => 'NIS-2024-00001',
                'nama_lengkap' => 'K.H. Ahmad Syatori',
                'nik' => '3302110101700001',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '1970-01-01',
                'jenis_kelamin' => 'L',
                'nomor_hp' => '081234567001',
                'email' => 'ahmad.syatori@nu.or.id',
                'alamat' => 'RT 01 RW 02 Desa Karangtengah',
                'desa_kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten_kota' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'jabatan' => 'Rais Syuriyah',
                'banom_id' => null,
                'status' => 'aktif',
                'tanggal_bergabung' => '2020-01-01',
                'tampil_publik' => true,
            ],
            [
                'nis' => 'NIS-2024-00002',
                'nama_lengkap' => 'K.H. Muhyiddin Amin',
                'nik' => '3302110202720002',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '1972-02-02',
                'jenis_kelamin' => 'L',
                'nomor_hp' => '081234567002',
                'email' => 'muhyiddin@nu.or.id',
                'alamat' => 'RT 03 RW 01 Desa Karangtengah',
                'desa_kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten_kota' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'jabatan' => 'Katib Syuriyah',
                'banom_id' => null,
                'status' => 'aktif',
                'tanggal_bergabung' => '2020-01-01',
                'tampil_publik' => true,
            ],
            [
                'nis' => 'NIS-2024-00003',
                'nama_lengkap' => 'H. M. Thohir, S.Ag.',
                'nik' => '3302110303750003',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '1975-03-03',
                'jenis_kelamin' => 'L',
                'nomor_hp' => '081234567003',
                'email' => 'thohir@nu.or.id',
                'alamat' => 'RT 02 RW 03 Desa Karangtengah',
                'desa_kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten_kota' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'jabatan' => 'Ketua Tanfidziyah',
                'banom_id' => null,
                'status' => 'aktif',
                'tanggal_bergabung' => '2021-02-15',
                'tampil_publik' => true,
            ],
            [
                'nis' => 'NIS-2024-00004',
                'nama_lengkap' => 'Ust. Sholahuddin, S.Pd.',
                'nik' => '3302110404800004',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '1980-04-04',
                'jenis_kelamin' => 'L',
                'nomor_hp' => '081234567004',
                'email' => 'sholahuddin@nu.or.id',
                'alamat' => 'RT 04 RW 02 Desa Karangtengah',
                'desa_kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten_kota' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'jabatan' => 'Sekretaris Tanfidziyah',
                'banom_id' => null,
                'status' => 'aktif',
                'tanggal_bergabung' => '2021-02-15',
                'tampil_publik' => true,
            ],
            [
                'nis' => 'NIS-2024-00005',
                'nama_lengkap' => 'H. Abdul Wahid',
                'nik' => '3302110505780005',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '1978-05-05',
                'jenis_kelamin' => 'L',
                'nomor_hp' => '081234567005',
                'email' => 'abdul.wahid@nu.or.id',
                'alamat' => 'RT 01 RW 01 Desa Karangtengah',
                'desa_kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten_kota' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'jabatan' => 'Bendahara',
                'banom_id' => null,
                'status' => 'aktif',
                'tanggal_bergabung' => '2021-02-15',
                'tampil_publik' => true,
            ],
            [
                'nis' => 'NIS-2024-00006',
                'nama_lengkap' => 'Sahabat M. Ilham Fauzi',
                'nik' => '3302110606900006',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '1990-06-06',
                'jenis_kelamin' => 'L',
                'nomor_hp' => '081322114455',
                'alamat' => 'Dusun Karanganyar, Karangtengah',
                'desa_kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten_kota' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'jabatan' => 'Ketua GP Ansor',
                'banom_id' => $banomModels['GP Ansor']->id,
                'status' => 'aktif',
                'tanggal_bergabung' => '2022-03-10',
                'tampil_publik' => true,
            ],
            [
                'nis' => 'NIS-2024-00007',
                'nama_lengkap' => 'Komandan Sugeng Riyadi',
                'nik' => '3302110707880007',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '1988-07-07',
                'jenis_kelamin' => 'L',
                'nomor_hp' => '081244556677',
                'alamat' => 'Dusun Krajan RT 02 RW 01',
                'desa_kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten_kota' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'jabatan' => 'Kepala Satkorkel Banser',
                'banom_id' => $banomModels['BANSER']->id,
                'status' => 'aktif',
                'tanggal_bergabung' => '2021-05-12',
                'tampil_publik' => true,
            ],
            [
                'nis' => 'NIS-2024-00008',
                'nama_lengkap' => 'Siti Nur Halimah, S.Pd.I',
                'nik' => '3302110808920008',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '1992-08-08',
                'jenis_kelamin' => 'P',
                'nomor_hp' => '081566778899',
                'alamat' => 'Dusun Babakan RT 03 RW 02',
                'desa_kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten_kota' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'jabatan' => 'Ketua Fatayat NU',
                'banom_id' => $banomModels['Fatayat NU']->id,
                'status' => 'aktif',
                'tanggal_bergabung' => '2022-01-20',
                'tampil_publik' => true,
            ],
            [
                'nis' => null,
                'nama_lengkap' => 'Ahmad Fathur Rahman',
                'nik' => '3302110909950009',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '1995-09-09',
                'jenis_kelamin' => 'L',
                'nomor_hp' => '081988776655',
                'alamat' => 'Dusun Karanganyar RT 05 RW 03',
                'desa_kelurahan' => 'Karangtengah',
                'kecamatan' => 'Colongok',
                'kabupaten_kota' => 'Banyumas',
                'provinsi' => 'Jawa Tengah',
                'jabatan' => 'Kader Muda',
                'banom_id' => $banomModels['GP Ansor']->id,
                'status' => 'menunggu_verifikasi',
                'tanggal_bergabung' => null,
                'tampil_publik' => false,
            ]
        ];

        foreach ($members as $m) {
            Member::updateOrCreate(['nik' => $m['nik']], $m);
        }

        // 7. BERITA (POSTS)
        $posts = [
            [
                'title' => 'Lailatul Ijtima\' PRNU Karangtengah Dihadiri Ratusan Jamaah Nahdliyin',
                'category_id' => $categoryModels['warta-ranting']->id,
                'author_id' => $admin->id,
                'excerpt' => 'Pengurus Ranting Nahdlatul Ulama (PRNU) Karangtengah kembali menggelar pengajian bulanan Lailatul Ijtima\' yang dirangkai dengan istighotsah kubro dan konsolidasi jam\'iyyah.',
                'content' => "Pengurus Ranting Nahdlatul Ulama (PRNU) Desa Karangtengah sukses menggelar kegiatan rutin bulanan Lailatul Ijtima' yang bertempat di Masjid Jami' Al-Huda Karangtengah pada Jumat malam Sabtu kemarin.\n\nAcara yang dihadiri ratusan jamaah dari kalangan kiai, sesepuh, pengurus harian syuriyah-tanfidziyah, serta jajaran Badan Otonom (Ansor, Banser, Fatayat, IPNU, IPPNU) berlangsung khusyuk dan penuh khidmah.\n\nRais Syuriyah PRNU Karangtengah, KH. Ahmad Syatori, dalam tausiyahnya menyampaikan pentingnya merawat tali ukhuwah dan keistiqomahan dalam menjaga amaliah Aswaja an-Nahdliyyah di tengah derasnya arus globalisasi digital.\n\n\"Lailatul Ijtima' bukan sekadar wadah berdoa bersama, melainkan momentum memperkuat ikatan batin antarkader dan jamaah agar selalu satu komando bersama para masyayikh,\" tegas beliau.",
                'status' => 'published',
                'views' => 142,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Banser Ranting Karangtengah Gelar Pelatihan Tanggap Bencana dan Apel Kesiapsiagaan',
                'category_id' => $categoryModels['kaderisasi-banom']->id,
                'author_id' => $admin->id,
                'excerpt' => 'Puluhan personel Satuan Koordinasi Kelompok (Satkorkel) Banser Karangtengah mengikuti pembekalan evakuasi bencana dan latihan ketahanan fisik.',
                'content' => "Menghadapi potensi curah hujan tinggi di wilayah pegunungan, Satkorkel Barisan Ansor Serbaguna (Banser) Ranting Karangtengah menyelenggarakan Apel Kesiapsiagaan dan Pelatihan Dasar Tanggap Bencana (BAGANA).\n\nKegiatan ini difokuskan pada simulasi penyelamatan darurat, mitigasi longsor, dan pembersihan drainase warga. Komandan Sugeng Riyadi menyatakan bahwa Banser selalu siap diterjunkan 24 jam untuk membantu masyarakat kapan pun dibutuhkan.",
                'status' => 'published',
                'views' => 98,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Penyaluran Infaq Koin NU Karangtengah Bantu Renovasi Rumah Dhuafa',
                'category_id' => $categoryModels['sosial-koin-nu']->id,
                'author_id' => $pengurus->id,
                'excerpt' => 'Berkat keikhlasan koin infaq warga nahdliyin setiap bulan, PRNU Karangtengah menyalurkan bantuan material bahan bangunan untuk merenovasi rumah warga kurang mampu.',
                'content' => "Gerakan Koin Nahdliyin (Koin NU) yang dikelola UPZIS PRNU Karangtengah membuktikan manfaat konkret bagi kemaslahatan masyarakat. Hari ini, pengurus menyalurkan santunan dan bahan bangunan semen serta atap seng untuk renovasi rumah Bapak Sastro di Dusun Karanganyar.\n\nKetua Tanfidziyah, H. M. Thohir, menyampaikan apresiasi setinggi-tingginya kepada seluruh warga yang istiqomah mengisi kaleng Koin NU. \"Dari uang receh seribu dua ribu rupiah yang dikumpulkan tiap bulan, kita mampu mewujudkan kerja-kerja kemanusiaan nyata,\" ungkapnya.",
                'status' => 'published',
                'views' => 215,
                'published_at' => now()->subDays(9),
            ]
        ];

        foreach ($posts as $p) {
            Post::updateOrCreate(
                ['title' => $p['title']],
                array_merge($p, ['slug' => Str::slug($p['title'])])
            );
        }

        // 8. AGENDA
        $agendas = [
            [
                'title' => 'Pengajian Rutin Ahad Pagi & Kajian Kitab Fathul Qorib',
                'slug' => 'pengajian-ahad-pagi-fathul-qorib',
                'description' => 'Kajian fikih ibadah bersama Katib Syuriyah KH. Muhyiddin Amin. Terbuka untuk seluruh jamaah dan warga umum.',
                'location' => 'Gedung MWC / Ranting NU Karangtengah',
                'start_at' => now()->addDays(3)->setTime(6, 30),
                'end_at' => now()->addDays(3)->setTime(8, 30),
                'organizer' => 'Lembaga Dakwah NU (LDNU)',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Lailatul Ijtima\' & Istighotsah Malam Ahad Kliwon',
                'slug' => 'lailatul-ijtima-malam-ahad-kliwon',
                'description' => 'Pembacaan Ratib al-Haddad, istighotsah masyayikh, dan koordinasi program kerja pengurus bersama seluruh Banom.',
                'location' => 'Masjid Jami\' Al-Huda Karangtengah',
                'start_at' => now()->addDays(10)->setTime(19, 30),
                'end_at' => now()->addDays(10)->setTime(22, 00),
                'organizer' => 'PRNU Karangtengah',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Peringatan Hari Santri Nasional (HSN) & Apel Akbar',
                'slug' => 'peringatan-hari-santri-nasional-apel-akbar',
                'description' => 'Upacara bendera Hari Santri, kirab santri, dan santunan anak yatim piatu.',
                'location' => 'Lapangan Desa Karangtengah',
                'start_at' => now()->addDays(25)->setTime(7, 30),
                'end_at' => now()->addDays(25)->setTime(12, 00),
                'organizer' => 'Panitia Peringatan Hari Santri PRNU',
                'status' => 'upcoming',
            ],
        ];

        foreach ($agendas as $ag) {
            Agenda::updateOrCreate(['slug' => $ag['slug']], $ag);
        }

        // 9. GALERI
        $gallery = Gallery::updateOrCreate(
            ['slug' => 'dokumentasi-lailatul-ijtima-bulanan'],
            [
                'title' => 'Dokumentasi Lailatul Ijtima\' & Dzikir Bersama',
                'description' => 'Suasana khidmat pengajian dan istighotsah warga Nahdlatul Ulama Desa Karangtengah.',
                'event_date' => now()->subDays(2),
                'created_by' => $admin->id,
                'status' => 'published',
            ]
        );

        // 10. DONASI / INFAQ
        $donations = [
            [
                'transaction_code' => 'INF202409010001',
                'donor_name' => 'H. Sugiyanto',
                'phone' => '081233445566',
                'email' => 'sugiyanto@email.com',
                'amount' => 500000,
                'donation_type' => 'infaq',
                'bank_name' => 'BSI',
                'transfer_date' => now()->subDays(5),
                'status' => 'confirmed',
                'confirmed_at' => now()->subDays(4),
                'confirmed_by' => $admin->id,
                'notes' => 'Infaq untuk kelancaran kegiatan Lailatul Ijtima.',
            ],
            [
                'transaction_code' => 'INF202409030002',
                'donor_name' => 'Hamba Allah',
                'phone' => '085711998877',
                'email' => null,
                'amount' => 250000,
                'donation_type' => 'sedekah',
                'bank_name' => 'BRI',
                'transfer_date' => now()->subDays(2),
                'status' => 'confirmed',
                'confirmed_at' => now()->subDays(1),
                'confirmed_by' => $admin->id,
                'notes' => 'Mohon didoakan agar keluarga sehat dan berkah.',
            ],
            [
                'transaction_code' => 'INF202409070003',
                'donor_name' => 'Ahmad Rifa\'i',
                'phone' => '081399887766',
                'email' => 'rifai@gmail.com',
                'amount' => 100000,
                'donation_type' => 'donasi_kegiatan',
                'bank_name' => 'BCA',
                'transfer_date' => now(),
                'status' => 'pending',
                'confirmed_at' => null,
                'confirmed_by' => null,
                'notes' => 'Donasi untuk Hari Santri.',
            ],
        ];

        foreach ($donations as $don) {
            Donation::updateOrCreate(['transaction_code' => $don['transaction_code']], $don);
        }
    }
}
