<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    
    @php
        // Varsayılan tema değerleri (eğer tema gönderilmemişse)
        $defaultTheme = [
            'primary' => '#4a90d9',
            'secondary' => '#2c3e50',
            'accent' => '#3498db',
            'light' => '#ecf0f1',
            'dark' => '#1a5276',
            'text' => '#333333',
            'note_bg' => '#fff3cd',
            'note_border' => '#ffc107',
            'note_text' => '#856404',
        ];
        $theme = $theme ?? $defaultTheme;
    @endphp
    
    <style>
        /* ================================
           TEMA RENKLERİ (DİNAMİK)
           ================================ */
        :root {
            --primary: {{ $theme['primary'] }};
            --secondary: {{ $theme['secondary'] }};
            --accent: {{ $theme['accent'] }};
            --light: {{ $theme['light'] }};
            --dark: {{ $theme['dark'] }};
            --text: {{ $theme['text'] }};
            --note-bg: {{ $theme['note_bg'] }};
            --note-border: {{ $theme['note_border'] }};
            --note-text: {{ $theme['note_text'] }};
        }
        
        @page {
            margin: 20mm 15mm;
        }
        
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: {{ $theme['text'] }};
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid {{ $theme['primary'] }};
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .header h1 {
            color: {{ $theme['secondary'] }};
            font-size: 24px;
            margin: 0 0 5px 0;
        }
        
        .header .subtitle {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0;
        }
        
        .meta-info {
            display: inline-block;
            background: {{ $theme['light'] }};
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 11px;
            margin-top: 10px;
        }
        
        .content-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
            overflow: hidden; /* clearfix için */
        }
        
        .content-section h2 {
            color: {{ $theme['primary'] }};
            font-size: 16px;
            border-left: 4px solid {{ $theme['primary'] }};
            padding-left: 10px;
            margin-bottom: 10px;
        }
        
        /* Metin ve resim yan yana düzeni */
        .content-wrapper {
            display: table;
            width: 100%;
        }
        
        .content-section .text {
            text-align: justify;
            margin-bottom: 10px;
        }
        
        .content-section.has-image .text {
            display: table-cell;
            vertical-align: top;
            width: 65%;
            padding-right: 15px;
        }
        
        .content-section .image-container {
            display: table-cell;
            vertical-align: top;
            width: 35%;
            text-align: center;
        }
        
        .content-section .image-container img {
            max-width: 100%;
            max-height: 150px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 5px;
            background: #fafafa;
        }
        
        .content-section .image-caption {
            font-size: 10px;
            color: #555;
            margin-top: 8px;
            text-align: center;
        }
        
        .content-section .image-caption .figure-number {
            font-weight: bold;
            color: {{ $theme['primary'] }};
        }
        
        .teacher-note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px 15px;
            margin: 10px 0;
            font-size: 11px;
        }
        
        .teacher-note::before {
            content: "💡 Öğretmen Notu: ";
            font-weight: bold;
            color: #856404;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #95a5a6;
            border-top: 1px solid {{ $theme['light'] }};
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p class="subtitle">{{ $subtitle }}</p>
        <div class="meta-info">
            <strong>{{ $subject }}</strong> | {{ $level }}
        </div>
    </div>

    @php $figureCounter = 0; @endphp
    @foreach($content as $section)
        @php 
            $hasImage = !empty($section['image_url']);
            if ($hasImage) $figureCounter++;
        @endphp
        <div class="content-section {{ $hasImage ? 'has-image' : '' }}">
            <h2>{{ $section['heading'] }}</h2>
            
            <div class="content-wrapper">
                <div class="text">
                    {!! nl2br(e($section['text'])) !!}
                </div>
                
                @if($hasImage)
                    <div class="image-container">
                        <img src="{{ $section['image_url'] }}" alt="{{ $section['heading'] }}">
                        <div class="image-caption">
                            <span class="figure-number">Şekil.{{ $figureCounter }}</span>@if(!empty($section['image_caption'])): {{ $section['image_caption'] }}@endif
                        </div>
                    </div>
                @endif
            </div>
            
            @if(!empty($section['teacher_note']))
                <div class="teacher-note">
                    {{ $section['teacher_note'] }}
                </div>
            @endif
        </div>
    @endforeach

    <div class="footer">
        LGS Kaynak PDF Maker | {{ date('d.m.Y') }}
    </div>
</body>
</html>
