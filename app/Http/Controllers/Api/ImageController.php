<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Resim yükle
     */
    public function upload(Request $request): JsonResponse
    {
        Log::info('IMAGE', ['action' => 'upload']);

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
        ]);

        $file = $request->file('image');
        
        // Benzersiz dosya adı oluştur
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // storage/app/public/pdf-images klasörüne kaydet
        $path = $file->storeAs('pdf-images', $filename, 'public');

        if (!$path) {
            return response()->json([
                'success' => false,
                'message' => 'Resim yüklenemedi'
            ], 500);
        }

        // Full URL oluştur
        $url = Storage::disk('public')->url($path);

        return response()->json([
            'success' => true,
            'message' => 'Resim başarıyla yüklendi',
            'data' => [
                'path' => $path,
                'url' => $url,
                'filename' => $filename,
            ]
        ]);
    }

    /**
     * Birden fazla resim yükle
     */
    public function uploadMultiple(Request $request): JsonResponse
    {
        Log::info('IMAGE', ['action' => 'uploadMultiple']);

        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $uploaded = [];

        foreach ($request->file('images') as $file) {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pdf-images', $filename, 'public');

            if ($path) {
                $uploaded[] = [
                    'path' => $path,
                    'url' => Storage::disk('public')->url($path),
                    'filename' => $filename,
                    'original_name' => $file->getClientOriginalName(),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($uploaded) . ' resim başarıyla yüklendi',
            'data' => $uploaded
        ]);
    }

    /**
     * Resim sil
     */
    public function destroy(Request $request): JsonResponse
    {
        Log::info('IMAGE', ['action' => 'destroy']);

        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        $path = $validated['path'];

        // Sadece pdf-images klasöründeki dosyaları silmeye izin ver
        if (!Str::startsWith($path, 'pdf-images/')) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz dosya yolu'
            ], 400);
        }

        if (!Storage::disk('public')->exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'Dosya bulunamadı'
            ], 404);
        }

        Storage::disk('public')->delete($path);

        return response()->json([
            'success' => true,
            'message' => 'Resim başarıyla silindi'
        ]);
    }

    /**
     * Tüm resimleri listele
     */
    public function index(): JsonResponse
    {
        Log::info('IMAGE', ['action' => 'index']);

        $files = Storage::disk('public')->files('pdf-images');

        $images = array_map(function ($file) {
            return [
                'path' => $file,
                'url' => Storage::disk('public')->url($file),
                'filename' => basename($file),
                'size' => Storage::disk('public')->size($file),
            ];
        }, $files);

        return response()->json([
            'success' => true,
            'data' => $images
        ]);
    }
}
