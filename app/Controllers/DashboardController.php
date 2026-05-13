<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Models\Child;

final class DashboardController extends Controller
{
    private User $userModel;
    private Child $childModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->childModel = new Child();
    }

    public function index(): void
    {
        $this->requireAuth();

        $user = current_user();
        $children = $this->userModel->getChildren((int) $user['id']);

        $totalStars = array_sum(array_map(static fn (array $child): int => (int) ($child['stars'] ?? 0), $children));
        $totalCoins = array_sum(array_map(static fn (array $child): int => (int) ($child['coins'] ?? 0), $children));

        $this->render('dashboard/index', [
            'children' => $children,
            'games' => $_SESSION['games'] ?? [],
            'metrics' => [
                'children' => count($children),
                'games' => count($_SESSION['games'] ?? []),
                'stars' => $totalStars,
                'coins' => $totalCoins,
            ],
        ]);
    }

    public function children(): void
    {
        $this->requireAuth();

        $user = current_user();
        $children = $this->userModel->getChildren((int) $user['id']);

        $this->render('dashboard/children', [
            'children' => $children,
        ]);
    }

    public function storeChild(): void
    {
        $this->requireAuth();

        $user = current_user();

        $name = trim((string) $this->requestInput('name', ''));
        $birthDate = trim((string) $this->requestInput('birth_date', ''));
        $gender = trim((string) $this->requestInput('gender', 'other'));

        $_SESSION['_old'] = [
            'name' => $name,
            'birth_date' => $birthDate,
            'gender' => $gender,
        ];

        if ($name === '' || $birthDate === '') {
            flash('error', 'Preencha nome e data de nascimento para cadastrar a criança.');
            $this->redirect('children');
        }

        $childData = [
            'user_id' => $user['id'],
            'name' => $name,
            'birth_date' => $birthDate,
            'gender' => $gender,
        ];

        $this->childModel->createChild($childData);

        unset($_SESSION['_old']);

        flash('success', 'Criança cadastrada com sucesso.');
        $this->redirect('children');
    }

    public function games(): void
    {
        $this->requireAuth();

        $this->render('dashboard/games', [
            'games' => $_SESSION['games'] ?? [],
        ]);
    }

    public function playAlphabet(): void
    {
        $this->requireAuth();

        // Renderizar diretamente o HTML do jogo
        header('Content-Type: text/html; charset=utf-8');
        include ROOT_PATH . '/public/games/alphabet/index.html';
        exit;
    }

    public function playGame(string $slug): void
    {
        $this->requireAuth();

        $games = $_SESSION['games'] ?? [];
        $game = null;

        foreach ($games as $g) {
            if (($g['slug'] ?? null) === $slug) {
                $game = $g;
                break;
            }
        }

        if (!$game) {
            http_response_code(404);
            $this->render('errors/404', ['message' => 'Jogo não encontrado.']);
            return;
        }

        // Jogos implementados
        $implementedGames = [
            'alphabet' => 'playAlphabet',
        ];

        if (isset($implementedGames[$slug])) {
            $method = $implementedGames[$slug];
            $this->$method();
            return;
        }

        // Jogo não implementado ainda - mostrar página em breve
        $this->render('dashboard/game-coming-soon', [
            'game' => $game,
        ]);
    }

    public function admin(): void
    {
        $this->requireAuth();
        $this->requireRole(['admin', 'teacher']);

        $children = $this->childModel->findAll();
        $games = $_SESSION['games'] ?? [];
        $plans = $_SESSION['plans'] ?? [];

        $this->render('dashboard/admin', [
            'children' => $children,
            'games' => $games,
            'plans' => $plans,
        ]);
    }
}
