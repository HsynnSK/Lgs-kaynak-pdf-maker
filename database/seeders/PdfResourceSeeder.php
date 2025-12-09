<?php

namespace Database\Seeders;

use App\Models\PdfResource;
use Illuminate\Database\Seeder;

class PdfResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Yeşil temalı kaynak
        $resource1 = PdfResource::create([
            'title' => 'Kareköklü İfadeler',
            'subtitle' => 'Yeni Nesil Sorular İçin Kritik Kurallar',
            'subject' => 'Matematik',
            'level' => '8. Sınıf LGS',
            'theme' => 'green',
        ]);

        $resource1->sections()->createMany([
            [
                'heading' => '1. Tam Kare Sayılar',
                'text' => "Bir tam sayının karesi olan pozitif tam sayılara tam kare sayılar denir. Örneğin: 1, 4, 9, 16, 25, 36, 49, 64, 81, 100... tam kare sayılardır.\n\nAlanı tam kare sayı olan karesel bölgelerin kenar uzunlukları daima tam sayıdır.",
                'image_url' => null,
                'image_caption' => 'Kenar uzunluğu ve alan ilişkisi',
                'teacher_note' => 'Sorularda "alanı 36 m² olan kare bahçe" dendiğinde hemen kenarın 6 olduğunu yapıştırın, düşünmeyin bile!',
                'order' => 1,
            ],
            [
                'heading' => '2. Karekök Alma İşlemi',
                'text' => "Verilen bir sayının hangi sayının karesi olduğunu bulma işlemine karekök alma denir. √ sembolü ile gösterilir.\n\n√16 = 4 (çünkü 4² = 16)\n√25 = 5 (çünkü 5² = 25)\n√81 = 9 (çünkü 9² = 81)",
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => 'Negatif sayıların karekökü alınmaz! √-16 diye bir şey görürseniz hemen üzerini çizin.',
                'order' => 2,
            ],
            [
                'heading' => '3. Yaklaşık Değer Bulma',
                'text' => "Tam kare olmayan sayıların karekökü iki tam sayı arasındadır.\n\nÖrneğin √20 sayısı:\n√16 = 4 ve √25 = 5 olduğundan\n4 < √20 < 5 şeklinde yazılır.",
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => null,
                'order' => 3,
            ],
        ]);

        // Turuncu temalı kaynak
        $resource2 = PdfResource::create([
            'title' => 'Türkçe Dil Bilgisi',
            'subtitle' => 'Sözcük Türleri ve Cümle Öğeleri',
            'subject' => 'Türkçe',
            'level' => '8. Sınıf LGS',
            'theme' => 'orange',
        ]);

        $resource2->sections()->createMany([
            [
                'heading' => '1. İsimler (Adlar)',
                'text' => "Canlı ve cansız varlıkları, kavramları, duyguları karşılayan sözcüklere isim denir.\n\nÖrnekler: kitap, kalem, mutluluk, İstanbul, Ayşe",
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => 'İsimlerin başına \"bir\" getirilebildiğini hatırlayın!',
                'order' => 1,
            ],
            [
                'heading' => '2. Sıfatlar',
                'text' => "İsimleri niteleyen veya belirten sözcüklere sıfat denir. Sıfatlar tek başlarına kullanılmaz, mutlaka bir isimden önce gelir.\n\nÖrnekler: güzel çiçek, üç elma, bu kitap",
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => 'Sıfat + İsim = Sıfat Tamlaması formülünü unutmayın!',
                'order' => 2,
            ],
        ]);

        // Mor temalı kaynak
        $resource3 = PdfResource::create([
            'title' => 'Hücre ve Bölünmeler',
            'subtitle' => 'Mitoz ve Mayoz Bölünme',
            'subject' => 'Fen Bilimleri',
            'level' => '8. Sınıf LGS',
            'theme' => 'purple',
        ]);

        $resource3->sections()->createMany([
            [
                'heading' => '1. Hücre Yapısı',
                'text' => "Hücre, canlıların yapı ve görev bakımından en küçük birimidir. Tüm canlılar hücrelerden oluşur.\n\nHücrenin temel kısımları:\n- Hücre zarı\n- Sitoplazma\n- Çekirdek",
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => 'Bitki hücresinde hücre duvarı ve kloroplast da bulunur!',
                'order' => 1,
            ],
            [
                'heading' => '2. Mitoz Bölünme',
                'text' => "Mitoz bölünme, bir hücreden iki özdeş hücre oluşmasıdır. Büyüme, gelişme ve yenilenme için gereklidir.\n\nEvreleri: Profaz → Metafaz → Anafaz → Telofaz",
                'image_url' => null,
                'image_caption' => null,
                'teacher_note' => 'PMAT kısaltmasını kullanarak evreleri kolayca hatırlayabilirsiniz!',
                'order' => 2,
            ],
        ]);

        $this->command->info('3 adet PDF kaynağı başarıyla oluşturuldu!');
        $this->command->info('- Kareköklü İfadeler (Yeşil tema)');
        $this->command->info('- Türkçe Dil Bilgisi (Turuncu tema)');
        $this->command->info('- Hücre ve Bölünmeler (Mor tema)');
    }
}
