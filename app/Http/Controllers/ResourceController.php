<?php

namespace App\Http\Controllers;

use App\Models\PdfResource;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ResourceController extends Controller
{
    // Tüm kaynakları listele
    public function index()
    {
        $resources = PdfResource::with('sections')->get();
        return view('resources.index', compact('resources'));
    }

    // Yeni kaynak oluşturma formu
    public function create()
    {
        return view('resources.create');
    }

    // Yeni kaynak kaydet
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'subject' => 'required|string|max:100',
            'level' => 'required|string|max:100',
            'theme' => 'nullable|string|in:blue,orange,green,purple,red,teal,pink,dark',
            'sections' => 'array',
            'sections.*.heading' => 'required|string|max:255',
            'sections.*.text' => 'required|string',
            'sections.*.image_url' => 'nullable|string',
            'sections.*.image_caption' => 'nullable|string|max:255',
            'sections.*.teacher_note' => 'nullable|string',
        ]);

        $resource = PdfResource::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'subject' => $validated['subject'],
            'level' => $validated['level'],
            'theme' => $validated['theme'] ?? 'blue',
        ]);

        if (isset($validated['sections'])) {
            foreach ($validated['sections'] as $index => $section) {
                $resource->sections()->create([
                    'heading' => $section['heading'],
                    'text' => $section['text'],
                    'image_url' => $section['image_url'] ?? null,
                    'image_caption' => $section['image_caption'] ?? null,
                    'teacher_note' => $section['teacher_note'] ?? null,
                    'order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('resources.index')->with('success', 'Kaynak başarıyla oluşturuldu.');
    }

    // Kaynak detay sayfası
    public function show(PdfResource $resource)
    {
        $resource->load('sections');
        return view('resources.show', compact('resource'));
    }

    // PDF olarak indir veya tarayıcıda görüntüle
    public function downloadPdf(PdfResource $resource)
    {
        $resource->load('sections');

        $data = [
            'title' => $resource->title,
            'subtitle' => $resource->subtitle,
            'subject' => $resource->subject,
            'level' => $resource->level,
            'theme' => $resource->getThemeColors(),
            'content' => $resource->sections->map(function ($section) {
                return [
                    'heading' => $section->heading,
                    'text' => $section->text,
                    'image_url' => $section->image_url,
                    'image_caption' => $section->image_caption,
                    'image_position' => $section->image_position ?? 'bottom',
                    'teacher_note' => $section->teacher_note,
                ];
            })->toArray(),
        ];

        $pdf = Pdf::loadView('pdf.resource-rich', $data);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        $filename = str_replace(' ', '-', strtolower($resource->title)) . '.pdf';
        
        return $pdf->stream($filename);
    }

    // Demo PDF - veritabanı olmadan test için
    // Kullanım: /pdf/demo?theme=orange
    public function downloadDemoPdf(Request $request)
    {
        // URL'den tema parametresi al (?theme=orange, ?theme=green vb.)
        $themeKey = $request->get('theme', 'blue');
        $themes = config('pdf-themes.themes');
        $theme = $themes[$themeKey] ?? $themes['blue'];

        // Resim yollarını hazırla (dosya varsa kullan, yoksa null)
        $image1Path = storage_path('app/public/pdf-images/test-image-1.png');
        $image2Path = storage_path('app/public/pdf-images/test-image-2.png');
        
        // Resmi base64'e çevir (DOMPDF için daha güvenilir)
        $image1 = file_exists($image1Path) ? 'data:image/png;base64,' . base64_encode(file_get_contents($image1Path)) : null;
        $image2 = file_exists($image2Path) ? 'data:image/png;base64,' . base64_encode(file_get_contents($image2Path)) : null;

        $data = [
            'title' => 'Kareköklü İfadeler',
            'subtitle' => 'Yeni Nesil Sorular İçin Kritik Kurallar',
            'subject' => 'Matematik',
            'level' => '8. Sınıf LGS',
            'theme' => $theme,
            'content' => [
                [
                    'heading' => '1. Tam Kare Sayılar',
                    'text' => "Bir tam sayının karesi olan pozitif tam sayılara tam kare sayılar denir. Alanı tam kare sayı olan karesel bölgelerin kenar uzunlukları daima tam sayıdır.\n\nÖrneğin: 1, 4, 9, 16, 25, 36, 49, 64, 81, 100 sayıları tam kare sayılardır.\n\nBu sayıların karekökü alındığında tam sayı elde edilir.",
                    'image_url' => $image1,
                    'image_caption' => 'Kenar uzunluğu ve alan ilişkisi',
                    'image_position' => 'right', // Yanda göster
                    'teacher_note' => 'Sorularda "alanı 36 m² olan kare bahçe" dendiğinde hemen kenarın 6 olduğunu yapıştırın, düşünmeyin bile!'
                ],
                [
                    'heading' => '2. Karekök Alma İşlemi',
                    'text' => "Verilen bir sayının hangi sayının karesi olduğunu bulma işlemine karekök alma denir. √ sembolü ile gösterilir.\n\n√16 = 4 (çünkü 4² = 16)\n√25 = 5 (çünkü 5² = 25)\n√81 = 9 (çünkü 9² = 81)",
                    'image_url' => $image2,
                    'image_caption' => 'Karekök fonksiyonu grafiği',
                    'image_position' => 'bottom', // Aşağıda göster
                    'teacher_note' => 'Negatif sayıların karekökü alınmaz! √-16 diye bir şey görürseniz hemen üzerini çizin.'
                ],
                [
                    'heading' => '3. Yaklaşık Değer Bulma',
                    'text' => "Tam kare olmayan sayıların karekökü iki tam sayı arasındadır.\n\nÖrneğin √20 sayısı:\n• √16 = 4\n• √25 = 5\n\nBu nedenle: 4 < √20 < 5",
                    'image_url' => null,
                    'image_caption' => null,
                    'image_position' => 'bottom',
                    'teacher_note' => 'Sayı doğrusu üzerinde göstermek soruları kolaylaştırır!'
                ]
            ]
        ];

        $pdf = Pdf::loadView('pdf.resource-rich', $data);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream('demo-kaynak.pdf');
    }
}