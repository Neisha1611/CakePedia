<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;

class RecipeSeeder extends Seeder
{
    /**
     * Seed 3 contoh resep kue.
     * Jalankan: php artisan db:seed --class=RecipeSeeder
     */
    public function run(): void
    {
        $recipes = [
            [
                'title'        => 'Croissant Mentega Klasik',
                'category'     => 'Pastry',
                'ingredients'  =>
                    "500 gr tepung terigu protein tinggi\n" .
                    "10 gr ragi instan\n" .
                    "10 gr garam\n" .
                    "60 gr gula pasir\n" .
                    "300 ml susu full-fat dingin\n" .
                    "250 gr mentega tawar (untuk laminating)\n" .
                    "1 butir telur (untuk olesan)",
                'instructions' =>
                    "1. Campur tepung, ragi, gula, dan garam dalam mangkuk besar.\n" .
                    "2. Tuang susu dingin perlahan, uleni hingga adonan kalis sekitar 5 menit. Jangan uleni berlebihan.\n" .
                    "3. Bentuk adonan menjadi bola pipih, bungkus plastik wrap, simpan di kulkas minimal 1 jam.\n" .
                    "4. Pipihkan mentega di antara dua lembar baking paper hingga berbentuk persegi.\n" .
                    "5. Keluarkan adonan, gilas menjadi persegi panjang dua kali ukuran mentega.\n" .
                    "6. Letakkan mentega di tengah adonan, lipat adonan menutup mentega.\n" .
                    "7. Gilas lagi, lipat 3 (letter fold). Istirahatkan di kulkas 30 menit. Ulangi 3 kali.\n" .
                    "8. Setelah folding terakhir, gilas setebal 4 mm, potong segitiga.\n" .
                    "9. Gulung dari ujung lebar ke ujung runcing, bentuk bulan sabit.\n" .
                    "10. Diamkan pada suhu ruang 2 jam hingga mengembang. Oles telur.\n" .
                    "11. Panggang di oven 200°C selama 18–20 menit hingga keemasan.",
                'image_url'    => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&q=80',
            ],
            [
                'title'        => 'Nastar Nanas Keju',
                'category'     => 'Cookies',
                'ingredients'  =>
                    "250 gr mentega tawar suhu ruang\n" .
                    "50 gr gula halus\n" .
                    "2 butir kuning telur\n" .
                    "350 gr tepung terigu protein rendah\n" .
                    "30 gr susu bubuk\n" .
                    "25 gr maizena\n" .
                    "1/4 sdt vanili bubuk\n" .
                    "— SELAI NANAS —\n" .
                    "500 gr nanas parut\n" .
                    "150 gr gula pasir\n" .
                    "2 lembar daun pandan\n" .
                    "— TOPPING —\n" .
                    "Kuning telur + sedikit madu (olesan)\n" .
                    "Keju cheddar parut secukupnya",
                'instructions' =>
                    "SELAI NANAS:\n" .
                    "1. Masak nanas parut dengan gula dan daun pandan di atas api sedang.\n" .
                    "2. Aduk terus hingga air menyusut dan selai mengental, kering, tidak lengket.\n" .
                    "3. Angkat, dinginkan, bentuk bola-bola kecil ± 8 gr.\n\n" .
                    "KULIT:\n" .
                    "4. Kocok mentega dan gula halus hingga creamy, masukkan kuning telur.\n" .
                    "5. Ayak tepung, susu bubuk, maizena, dan vanili. Masukkan ke adonan mentega.\n" .
                    "6. Aduk dengan spatula hingga bersatu (jangan over-mix).\n" .
                    "7. Ambil adonan kulit ± 10 gr, pipihkan, isi selai nanas, tutup dan bulatkan.\n" .
                    "8. Tata di loyang, oles tipis kuning telur + madu.\n" .
                    "9. Panggang 160°C selama 15 menit, keluarkan, taburkan keju parut.\n" .
                    "10. Lanjut panggang 5–7 menit hingga keemasan. Dinginkan sebelum disimpan.",
                'image_url'    => 'https://images.unsplash.com/photo-1607920592519-bab4e9c2db33?w=600&q=80',
            ],
            [
                'title'        => 'Klepon Pandan Gula Merah',
                'category'     => 'Traditional Bites',
                'ingredients'  =>
                    "200 gr tepung ketan putih\n" .
                    "1 sdt pasta pandan (atau 5 lembar daun pandan + 100 ml air, diblender)\n" .
                    "175 ml air hangat (sesuaikan kekentalan adonan)\n" .
                    "1/4 sdt garam\n" .
                    "— ISI —\n" .
                    "100 gr gula merah / gula aren, serut halus\n" .
                    "— BALUTAN —\n" .
                    "150 gr kelapa parut segar\n" .
                    "1/4 sdt garam\n" .
                    "2 lembar daun pandan",
                'instructions' =>
                    "1. Campur kelapa parut, garam, dan daun pandan. Kukus 10 menit, sisihkan.\n" .
                    "2. Larutkan pasta pandan dalam air hangat, beri garam.\n" .
                    "3. Tuang larutan pandan ke tepung ketan sedikit demi sedikit sambil diuleni hingga kalis dan tidak lengket.\n" .
                    "4. Ambil adonan ± 15 gr, pipihkan, isi dengan 1 sdt gula merah serut.\n" .
                    "5. Bulatkan rapat, pastikan tidak ada celah agar gula tidak bocor saat direbus.\n" .
                    "6. Didihkan air dalam panci, masukkan klepon.\n" .
                    "7. Rebus hingga klepon mengapung + 2 menit lagi. Angkat, tiriskan sebentar.\n" .
                    "8. Gulingkan klepon panas di atas kelapa parut kukus hingga terbalut rata.\n" .
                    "9. Sajikan segera selagi hangat.",
                'image_url'    => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=600&q=80',
            ],
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}