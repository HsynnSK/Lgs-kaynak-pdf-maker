<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PDF Renk Temaları
    |--------------------------------------------------------------------------
    |
    | Burada PDF için kullanılabilecek hazır renk temalarını tanımlayabilirsiniz.
    | Her tema için: primary (ana renk), secondary (ikincil), accent (vurgu),
    | light (açık ton), dark (koyu ton) ve text (metin rengi) tanımlanır.
    |
    */

    'themes' => [
        'blue' => [
            'name' => 'Mavi',
            'primary' => '#4a90d9',
            'secondary' => '#2c3e50',
            'accent' => '#3498db',
            'light' => '#ecf0f1',
            'dark' => '#1a5276',
            'text' => '#333333',
            'note_bg' => '#e3f2fd',
            'note_border' => '#2196f3',
            'note_text' => '#0d47a1',
        ],

        'orange' => [
            'name' => 'Turuncu',
            'primary' => '#FF8C00',
            'secondary' => '#d84315',
            'accent' => '#ff9800',
            'light' => '#FFF3E0',
            'dark' => '#e65100',
            'text' => '#333333',
            'note_bg' => '#fff3cd',
            'note_border' => '#ffc107',
            'note_text' => '#856404',
        ],

        'green' => [
            'name' => 'Yeşil',
            'primary' => '#27ae60',
            'secondary' => '#1e8449',
            'accent' => '#2ecc71',
            'light' => '#e8f8f5',
            'dark' => '#145a32',
            'text' => '#333333',
            'note_bg' => '#d4edda',
            'note_border' => '#28a745',
            'note_text' => '#155724',
        ],

        'purple' => [
            'name' => 'Mor',
            'primary' => '#9b59b6',
            'secondary' => '#6c3483',
            'accent' => '#a569bd',
            'light' => '#f5eef8',
            'dark' => '#4a235a',
            'text' => '#333333',
            'note_bg' => '#e8daef',
            'note_border' => '#8e44ad',
            'note_text' => '#512e5f',
        ],

        'red' => [
            'name' => 'Kırmızı',
            'primary' => '#e74c3c',
            'secondary' => '#c0392b',
            'accent' => '#ec7063',
            'light' => '#fdedec',
            'dark' => '#922b21',
            'text' => '#333333',
            'note_bg' => '#f8d7da',
            'note_border' => '#dc3545',
            'note_text' => '#721c24',
        ],

        'teal' => [
            'name' => 'Turkuaz',
            'primary' => '#17a2b8',
            'secondary' => '#138496',
            'accent' => '#20c997',
            'light' => '#e0f7fa',
            'dark' => '#0c5460',
            'text' => '#333333',
            'note_bg' => '#d1ecf1',
            'note_border' => '#17a2b8',
            'note_text' => '#0c5460',
        ],

        'pink' => [
            'name' => 'Pembe',
            'primary' => '#e91e63',
            'secondary' => '#c2185b',
            'accent' => '#f06292',
            'light' => '#fce4ec',
            'dark' => '#880e4f',
            'text' => '#333333',
            'note_bg' => '#f8bbd9',
            'note_border' => '#e91e63',
            'note_text' => '#880e4f',
        ],

        'dark' => [
            'name' => 'Koyu',
            'primary' => '#34495e',
            'secondary' => '#2c3e50',
            'accent' => '#5d6d7e',
            'light' => '#f4f6f7',
            'dark' => '#1c2833',
            'text' => '#333333',
            'note_bg' => '#d5d8dc',
            'note_border' => '#5d6d7e',
            'note_text' => '#2c3e50',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Varsayılan Tema
    |--------------------------------------------------------------------------
    */
    'default' => 'blue',
];
