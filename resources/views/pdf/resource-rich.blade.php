<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 20mm 15mm;
        }
        
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #4a90d9;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .header h1 {
            color: #2c3e50;
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
            background: #ecf0f1;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 11px;
            margin-top: 10px;
        }
        
        .content-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .content-section h2 {
            color: #4a90d9;
            font-size: 16px;
            border-left: 4px solid #4a90d9;
            padding-left: 10px;
            margin-bottom: 10px;
        }
        
        .content-section .text {
            text-align: justify;
            margin-bottom: 10px;
        }
        
        .content-section .image-container {
            text-align: center;
            margin: 15px 0;
        }
        
        .content-section .image-container img {
            max-width: 200px;
            max-height: 150px;
        }
        
        .content-section .image-caption {
            font-size: 10px;
            color: #7f8c8d;
            font-style: italic;
            margin-top: 5px;
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
            border-top: 1px solid #ecf0f1;
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

    @foreach($content as $section)
        <div class="content-section">
            <h2>{{ $section['heading'] }}</h2>
            
            <div class="text">
                {{ $section['text'] }}
            </div>
            
            @if(!empty($section['image_url']))
                <div class="image-container">
                    <img src="{{ $section['image_url'] }}" alt="{{ $section['heading'] }}">
                    @if(!empty($section['image_caption']))
                        <div class="image-caption">{{ $section['image_caption'] }}</div>
                    @endif
                </div>
            @endif
            
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
