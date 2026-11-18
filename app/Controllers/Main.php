<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Main extends BaseController
{
    public function index()
    {
        $today = new \DateTimeImmutable('today');
        $monday = $today->modify('monday this week');

        //pak nahradit z db
        $departureCounts = [18, 22, 20, 24, 21, 14, 8];

        return view('index', [
            'departureCounts' => $departureCounts,
            'weekStart'       => $monday->format('d.m.Y'),
            'weekEnd'         => $monday->modify('+6 days')->format('d.m.Y'),
        ]);
    }
}
