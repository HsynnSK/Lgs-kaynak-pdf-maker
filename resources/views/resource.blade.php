<!DOCTYPE html>
<html lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; font-family: 'DejaVu Sans', sans-serif; color: #333; }
        
        /* Renk Paleti */
        .bg-orange { background-color: #FF8C00; }
        .text-orange { color: #FF8C00; }
        .bg-light { background-color: #FFF3E0; }
        
        /* KAPAK TASARIMI */
        .cover-page {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #FFF3E0 0%, #FFFFFF 100%);
            position: relative;
            text-align: center;
        }
        .cover-logo {
            padding-top: 100px;
            font-size: 40px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #FF8C00;
        }
        .cover-title {
            font-size: 36px;
            margin-top: 50px;
            color: #222;
            padding: 0 40px;
        }
        .cover-subtitle {
            font-size: 18px;
            color: #666;
            margin-top: 20px;
            font-style: italic;
        }
        .cover-decoration {
            width: 100%;
            height: 20px;
            background-color: #FF8C00;
            position: absolute;
            bottom: 150px;
        }
        .cover-footer {
            position: absolute;
            bottom: 50px;
            width: 100%;
            font-size: 14px;
            color: #888;
        }

        /* İÇERİK SAYFALARI */
        .page {
            padding: 40px;
            page-break-after: always;
        }
        .content-header {
            border-bottom: 2px solid #FF8C00;
            margin-bottom: 30px;
            padding-bottom: 10px;
            display: table;
            width: 100%;
        }
        .topic-badge {
            background: #FF8C00;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Zengin İçerik Kutuları */
        .section-box {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #d84315;
            margin-bottom: 10px;
            border-left: 5px solid #FF8C00;
            padding-left: 10px;
        }
        .text-content {
            font-size: 14px;
            line-height: 1.6;
            text-align: justify;
        }

        /* Görsel Alanı */
        .image-container {
            text-align: center;
            margin: 15px 0;
            border: 1px dashed #ccc;
            padding: 10px;
            background: #fff;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            max-height: 200px;
        }
        .img-caption {
            font-size: 11px;
            color: #777;
            margin-top: 5px;
            font-style: italic;
        }

        /* "Hoca Notu" - İnsan Dokunuşu */
        .teacher-note {
            background-color: #e3f2fd; /* Mavi tonu, turuncuyla kontrast */
            border: 1px solid #90caf9;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            position: relative;
        }
        .note-icon {
            position: absolute;
            top: -10px;
            left: 20px;
            background: #2196f3;
            color: white;
            padding: 2px 10px;
            font-size: 11px;
            border-radius: 5px;
            font-weight: bold;
        }
        .note-text {
            font-size: 13px;
            color: #333;
            font-style: italic;
        }

        /* Alt Bilgi */
        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 30px;
            background-color: #f5f5f5;
            text-align: center;
            line-height: 30px;
            font-size: 10px;
            color: #aaa;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <div class="cover-page">
        <div class="cover-logo">MINDORA</div>
        <div class="cover-title">{{ $title }}</div>
        <div class="cover-subtitle">{{ $subtitle ?? 'Başarıya Giden Yolda Pratik Notlar' }}</div>
        
        <div style="margin-top: 50px;">
            <div style="width: 100px; height: 100px; background: #eee; border-radius: 50%; margin: 0 auto; line-height: 100px; color: #ccc;">Maskot</div>
        </div>

        <div class="cover-decoration"></div>
        <div class="cover-footer">
            www.mindora.com | {{ date('Y') }}<br>
            Kişiye Özel Hazırlanmıştır
        </div>
        <div style="page-break-after: always;"></div>
    </div>

    <div class="page">
        <div class="content-header">
            <div style="float: left; font-weight: bold; color: #444;">{{ $subject }}</div>
            <div style="float: right;" class="topic-badge">{{ $level ?? 'LGS Hazırlık' }}</div>
        </div>

        @foreach($content as $item)
            <div class="section-box">
                <div class="section-title">{{ $item['heading'] }}</div>
                
                <div class="text-content">
                    {!! nl2br(e($item['text'])) !!}
                </div>

                @if(isset($item['image_url']) && $item['image_url'])
                    <div class="image-container">
                        <img src="{{ $item['image_url'] }}">
                        @if(isset($item['image_caption']))
                            <div class="img-caption">{{ $item['image_caption'] }}</div>
                        @endif
                    </div>
                @endif

                @if(isset($item['teacher_note']) && $item['teacher_note'])
                    <div class="teacher-note">
                        <div class="note-icon">💡 İPUCU</div>
                        <div class="note-text">
                            "{{ $item['teacher_note'] }}"
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Sayfa {PAGE_NUM} / {PAGE_COUNT} - Mindora Özel Ders Platformu";
            $font = $fontMetrics->get_font("DejaVu Sans, sans-serif", "normal");
            $size = 9;
            $color = array(0.5, 0.5, 0.5);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text(270, 820, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>
</html>