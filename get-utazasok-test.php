<?php
header('Content-Type: application/json');

// Return hard-coded test data to see if the problem is with database or images
$test_data = [
    [
        'utazas_id' => 1,
        'utazas_elnevezese' => 'Test Paris Trip',
        'utazas_ideje' => '2024-06-15',
        'desztinacio' => 'Paris',
        'ar' => '150000',
        'boritokep' => 'borito_kepek/paris.svg',
        'leiras' => 'Test description',
        'indulasi_datum' => '2024-06-15',
        'visszaindulas_datum' => '2024-06-22',
        'indulasi_helyszin' => 'Budapest'
    ],
    [
        'utazas_id' => 2,
        'utazas_elnevezese' => 'Test Tokyo Trip',
        'utazas_ideje' => '2024-07-10',
        'desztinacio' => 'Tokyo',
        'ar' => '320000',
        'boritokep' => 'borito_kepek/tokyo.svg',
        'leiras' => 'Test description',
        'indulasi_datum' => '2024-07-10',
        'visszaindulas_datum' => '2024-07-17',
        'indulasi_helyszin' => 'Budapest'
    ],
    [
        'utazas_id' => 3,
        'utazas_elnevezese' => 'Test London Trip',
        'utazas_ideje' => '2024-08-05',
        'desztinacio' => 'London',
        'ar' => '210000',
        'boritokep' => 'borito_kepek/london.svg',
        'leiras' => 'Test description',
        'indulasi_datum' => '2024-08-05',
        'visszaindulas_datum' => '2024-08-12',
        'indulasi_helyszin' => 'Budapest'
    ]
];

echo json_encode($test_data, JSON_UNESCAPED_UNICODE);
?>