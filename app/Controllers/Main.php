<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Main extends BaseController
{
    public function index() //rozdělit pak na jednotlivé stránky; teďka je všecko v jednom, aby idk => předělat!!!
    {
        $today = new \DateTimeImmutable('today');
        $monday = $today->modify('monday this week');

        //nahradat všecka data pak z db
        $departureCounts = [18, 22, 20, 24, 21, 14, 8];
        $stops = [
            [
                'name' => 'Hlavní nádraží',
                'lat' => 49.190, 'lng' => 16.612,
                'departures' => ['2:23 AAAAA', 'AAAAAA', 'AAAAAAAAAA'],
            ],
        ];

        return view('index', [
            'departureCounts' => $departureCounts,
            'weekStart'       => $monday->format('d.m.Y'),
            'weekEnd'         => $monday->modify('+6 days')->format('d.m.Y'),
            'stops'           => $stops,
        ]);
    }
}
