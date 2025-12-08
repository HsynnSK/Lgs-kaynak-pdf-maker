<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PdfResource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // PDF Test Kaynağı 1
        $resource1 = PdfResource::create([
            'title' => 'Kareköklü İfadeler',
            'subtitle' => 'Yeni Nesil Sorular İçin Kritik Kurallar',
            'subject' => 'Matematik',
            'level' => '8. Sınıf LGS',
        ]);

        $resource1->sections()->createMany([
            [
                'heading' => '1. Tam Kare Sayılar',
                'text' => 'Bir tam sayının karesi olan pozitif tam sayılara tam kare sayılar denir. Alanı tam kare sayı olan karesel bölgelerin kenar uzunlukları daima tam sayıdır.',
                'image_url' => null,
                'image_caption' => 'Kenar uzunluğu ve alan ilişkisi',
                'teacher_note' => 'Sorularda "alanı 36 m² olan kare bahçe" dendiğinde hemen kenarın 6 olduğunu yapıştırın!',
                'order' => 1,
            ],
            [
                'heading' => '2. Karekök Alma İşlemi',
                'text' => 'Verilen bir sayının hangi sayının karesi olduğunu bulma işlemine karekök alma denir. √ sembolü ile gösterilir. Örneğin √25 = 5 çünkü 5² = 25.',
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => 'Negatif sayıların karekökü alınmaz! √-16 diye bir şey görürseniz hemen üzerini çizin.',
                'order' => 2,
            ],
            [
                'heading' => '3. Yaklaşık Değer Bulma',
                'text' => 'Tam kare olmayan sayıların karekökü iki tam sayı arasındadır. Örneğin √20 sayısı; √16 (4) ile √25 (5) arasındadır. Yani 4 < √20 < 5 şeklinde yazılır.',
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => null,
                'order' => 3,
            ],
        ]);

        // PDF Test Kaynağı 2
        $resource2 = PdfResource::create([
            'title' => 'Osmanlı Devleti Kuruluş Dönemi',
            'subtitle' => 'LGS Tarih - Önemli Olaylar ve Kişiler',
            'subject' => 'İnkılap Tarihi',
            'level' => '8. Sınıf LGS',
        ]);

        $resource2->sections()->createMany([
            [
                'heading' => '1. Osmanlı\'nın Kuruluşu',
                'text' => 'Osmanlı Devleti 1299 yılında Osman Bey tarafından kurulmuştur. Söğüt ve Domaniç çevresinde küçük bir beylik olarak başlayan devlet, zamanla büyük bir imparatorluk haline gelmiştir.',
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => 'Kuruluş tarihi 1299 ve kurucu Osman Bey - bu ikisini asla karıştırmayın!',
                'order' => 1,
            ],
            [
                'heading' => '2. İlk Padişahlar',
                'text' => 'Osman Bey\'den sonra sırasıyla Orhan Bey, I. Murat ve Yıldırım Bayezid tahta geçmiştir. Her biri devletin büyümesine önemli katkılar sağlamıştır.',
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => 'Padişah sıralaması: Osman → Orhan → Murat → Bayezid (Baş harfleri: O-O-M-B)',
                'order' => 2,
            ],
        ]);
    }
}
