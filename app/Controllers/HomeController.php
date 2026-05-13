<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;

final class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('home', [
            'games' => array_slice($_SESSION['games'] ?? [], 0, 3),
            'plans' => $_SESSION['plans'] ?? [],
        ]);
    }
}
