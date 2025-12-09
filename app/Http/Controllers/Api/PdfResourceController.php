<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PdfResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfResourceController extends Controller
{
    // Tüm kaynakları listele
    public function index(Request $request): JsonResponse
    {
        Log::info('PDF_RESOURCE', ['action' => 'index']);

        $resources = PdfResource::with('sections')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $resources
        ]);
    }

    // Yeni kaynak oluştur
    public function store(Request $request): JsonResponse
    {
        Log::info('PDF_RESOURCE', ['action' => 'store', 'data' => $request->all()]);

        // Gelen verileri doğrula
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
            'sections.*.order' => 'nullable|integer',
        ]);

        // Yeni kaynak oluştur
        $resource = PdfResource::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'subject' => $validated['subject'],
            'level' => $validated['level'],
            'theme' => $validated['theme'] ?? 'blue',
        ]);

        // Bölümleri oluştur
        if (isset($validated['sections'])) {
            foreach ($validated['sections'] as $index => $section) {
                $resource->sections()->create([
                    'heading' => $section['heading'],
                    'text' => $section['text'],
                    'image_url' => $section['image_url'] ?? null,
                    'image_caption' => $section['image_caption'] ?? null,
                    'teacher_note' => $section['teacher_note'] ?? null,
                    'order' => $section['order'] ?? $index + 1,
                ]);
            }
        }

        $resource->load('sections');

        return response()->json([
            'success' => true,
            'message' => 'Kaynak başarıyla oluşturuldu',
            'data' => $resource
        ], 201);
    }

    // Tek kaynak getir (ID ile)
    public function show(int $id): JsonResponse
    {
        Log::info('PDF_RESOURCE', ['action' => 'show', 'id' => $id]);

        $resource = PdfResource::with('sections')->find($id);

        if (!$resource) {
            return response()->json([
                'success' => false,
                'message' => 'Kaynak bulunamadı'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $resource
        ]);
    }

    // Kaynak güncelle
    public function update(Request $request, int $id): JsonResponse
    {
        Log::info('PDF_RESOURCE', ['action' => 'update', 'id' => $id, 'data' => $request->all()]);

        $resource = PdfResource::find($id);

        if (!$resource) {
            return response()->json([
                'success' => false,
                'message' => 'Kaynak bulunamadı'
            ], 404);
        }

        // Gelen verileri doğrula
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'subject' => 'sometimes|required|string|max:100',
            'level' => 'sometimes|required|string|max:100',
            'theme' => 'nullable|string|in:blue,orange,green,purple,red,teal,pink,dark',
            'sections' => 'array',
            'sections.*.id' => 'nullable|integer',
            'sections.*.heading' => 'required|string|max:255',
            'sections.*.text' => 'required|string',
            'sections.*.image_url' => 'nullable|string',
            'sections.*.image_caption' => 'nullable|string|max:255',
            'sections.*.teacher_note' => 'nullable|string',
            'sections.*.order' => 'nullable|integer',
        ]);

        // Kaynak bilgilerini güncelle
        $resource->update([
            'title' => $validated['title'] ?? $resource->title,
            'subtitle' => $validated['subtitle'] ?? $resource->subtitle,
            'subject' => $validated['subject'] ?? $resource->subject,
            'level' => $validated['level'] ?? $resource->level,
            'theme' => $validated['theme'] ?? $resource->theme,
        ]);

        // Bölümleri güncelle (varsa)
        if (isset($validated['sections'])) {
            // Önce mevcut bölümleri sil
            $resource->sections()->delete();
            
            // Yeni bölümleri oluştur
            foreach ($validated['sections'] as $index => $section) {
                $resource->sections()->create([
                    'heading' => $section['heading'],
                    'text' => $section['text'],
                    'image_url' => $section['image_url'] ?? null,
                    'image_caption' => $section['image_caption'] ?? null,
                    'teacher_note' => $section['teacher_note'] ?? null,
                    'order' => $section['order'] ?? $index + 1,
                ]);
            }
        }

        $resource->load('sections');

        return response()->json([
            'success' => true,
            'message' => 'Kaynak başarıyla güncellendi',
            'data' => $resource
        ]);
    }

    // Kaynak sil
    public function destroy(int $id): JsonResponse
    {
        Log::info('PDF_RESOURCE', ['action' => 'destroy', 'id' => $id]);

        $resource = PdfResource::find($id);

        if (!$resource) {
            return response()->json([
                'success' => false,
                'message' => 'Kaynak bulunamadı'
            ], 404);
        }

        $resource->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kaynak başarıyla silindi'
        ]);
    }

    // PDF olarak indir veya tarayıcıda görüntüle
    public function downloadPdf(int $id)
    {
        Log::info('PDF_RESOURCE', ['action' => 'downloadPdf', 'id' => $id]);

        $resource = PdfResource::with('sections')->find($id);

        if (!$resource) {
            return response()->json([
                'success' => false,
                'message' => 'Kaynak bulunamadı'
            ], 404);
        }

        $data = [
            'title' => $resource->title,
            'subtitle' => $resource->subtitle,
            'subject' => $resource->subject,
            'level' => $resource->level,
            'theme' => $resource->getThemeColors(),
            'content' => $resource->sections->map(function ($section) {
                // Storage'daki resmi tam path olarak al (DOMPDF için)
                $imageUrl = null;
                if ($section->image_url) {
                    // Eğer storage path ise (pdf-images/ ile başlıyorsa)
                    if (str_starts_with($section->image_url, 'pdf-images/')) {
                        $imageUrl = storage_path('app/public/' . $section->image_url);
                    } 
                    // Eğer tam URL ise olduğu gibi kullan
                    elseif (str_starts_with($section->image_url, 'http')) {
                        $imageUrl = $section->image_url;
                    }
                    // Diğer durumlar için storage URL
                    else {
                        $imageUrl = storage_path('app/public/' . $section->image_url);
                    }
                }
                
                return [
                    'heading' => $section->heading,
                    'text' => $section->text,
                    'image_url' => $imageUrl,
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

    // Demo PDF - test için (veritabanı gerektirmez)
    public function demoPdf()
    {
        Log::info('PDF_RESOURCE', ['action' => 'demoPdf']);

        $data = [
            'title' => 'Kareköklü İfadeler',
            'subtitle' => 'Yeni Nesil Sorular İçin Kritik Kurallar',
            'subject' => 'Matematik',
            'level' => '8. Sınıf LGS',
            'content' => [
                [
                    'heading' => '1. Tam Kare Sayılar',
                    'text' => "Bir tam sayının karesi olan pozitif tam sayılara tam kare sayılar denir.",
                    'image_url' => null,
                    'image_caption' => 'Kenar uzunluğu ve alan ilişkisi',
                    'teacher_note' => 'Sorularda "alanı 36 m² olan kare bahçe" dendiğinde hemen kenarın 6 olduğunu yapıştırın!'
                ],
                [
                    'heading' => '2. Karekök Alma İşlemi',
                    'text' => "Verilen bir sayının hangi sayının karesi olduğunu bulma işlemine karekök alma denir.",
                    'image_url' => null,
                    'image_caption' => null,
                    'teacher_note' => 'Negatif sayıların karekökü alınmaz!'
                ],
            ]
        ];

        $pdf = Pdf::loadView('pdf.resource-rich', $data);
        $pdf->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream('demo-kaynak.pdf');
    }
}
