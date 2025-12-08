<?php

namespace App\Http\Controllers;

use App\Models\PdfResource;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ResourceController extends Controller
{
    /**
     * Tüm kaynakları listele
     */
    public function index()
    {
        $resources = PdfResource::with('sections')->get();
        return view('resources.index', compact('resources'));
    }

    /**
     * Yeni kaynak oluşturma formu
     */
    public function create()
    {
        return view('resources.create');
    }

    /**
     * Yeni kaynak kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'subject' => 'required|string|max:100',
            'level' => 'required|string|max:100',
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

    /**
     * Kaynak detay sayfası
     */
    public function show(PdfResource $resource)
    {
        $resource->load('sections');
        return view('resources.show', compact('resource'));
    }

    /**
     * PDF olarak indir/görüntüle
     */
    public function downloadPdf(PdfResource $resource)
    {
        $resource->load('sections');

        $data = [
            'title' => $resource->title,
            'subtitle' => $resource->subtitle,
            'subject' => $resource->subject,
            'level' => $resource->level,
            'content' => $resource->sections->map(function ($section) {
                return [
                    'heading' => $section->heading,
                    'text' => $section->text,
                    'image_url' => $section->image_url,
                    'image_caption' => $section->image_caption,
                    'teacher_note' => $section->teacher_note,
                ];
            })->toArray(),
        ];

        $pdf = Pdf::loadView('pdf.resource-rich', $data);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        $filename = str_replace(' ', '-', strtolower($resource->title)) . '.pdf';
        
        return $pdf->stream($filename);
    }

    /**
     * Demo PDF (veritabanı olmadan test için)
     */
    public function downloadDemoPdf()
    {
        $data = [
            'title' => 'Kareköklü İfadeler',
            'subtitle' => 'Yeni Nesil Sorular İçin Kritik Kurallar',
            'subject' => 'Matematik',
            'level' => '8. Sınıf LGS',
            'content' => [
                [
                    'heading' => '1. Tam Kare Sayılar',
                    'text' => "Bir tam sayının karesi olan pozitif tam sayılara tam kare sayılar denir. Alanı tam kare sayı olan karesel bölgelerin kenar uzunlukları daima tam sayıdır.",
                    'image_url' => public_path('images/pdf-assets/geometry-square.png'),
                    'image_caption' => 'Kenar uzunluğu ve alan ilişkisi',
                    'teacher_note' => 'Sorularda "alanı 36 m² olan kare bahçe" dendiğinde hemen kenarın 6 olduğunu yapıştırın, düşünmeyin bile!'
                ],
                [
                    'heading' => '2. Karekök Alma İşlemi',
                    'text' => "Verilen bir sayının hangi sayının karesi olduğunu bulma işlemine karekök alma denir. √ sembolü ile gösterilir.",
                    'image_url' => null,
                    'teacher_note' => 'Negatif sayıların karekökü alınmaz! √-16 diye bir şey görürseniz hemen üzerini çizin.'
                ],
                [
                    'heading' => '3. Yaklaşık Değer Bulma',
                    'text' => "Tam kare olmayan sayıların karekökü iki tam sayı arasındadır. Örneğin √20 sayısı; √16 (4) ile √25 (5) arasındadır.",
                    'image_url' => null,
                    'image_caption' => null,
                    'teacher_note' => null
                ]
            ]
        ];

        $pdf = Pdf::loadView('pdf.resource-rich', $data);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream('demo-kaynak.pdf');
    }
}