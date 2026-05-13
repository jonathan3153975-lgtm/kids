<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogos - Kids Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #25415d;
            --secondary-color: #6c8ead;
            --accent-color: #ff6f6f;
            --success-color: #4ade80;
            --warning-color: #fbbf24;
            --light-bg: #f4fbff;
            --card-shadow: 0 8px 25px rgba(37, 65, 93, 0.1);
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e8f4fd 100%);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: var(--card-shadow);
        }

        .game-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
        }

        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(37, 65, 93, 0.15);
        }

        .game-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, var(--accent-color), #ff9d5c);
            color: white;
        }

        .game-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .game-description {
            color: #666;
            margin-bottom: 1rem;
        }

        .btn-play {
            background: linear-gradient(135deg, var(--success-color), #22c55e);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .btn-play:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #22c55e, var(--success-color));
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .breadcrumb {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/dashboard">
                <span class="fw-bold fs-4">🎓 Kids Platform</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/games">Jogos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Jogos</li>
            </ol>
        </nav>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Jogos Disponíveis</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Jogos Completados</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <div class="stat-number">1,250</div>
                    <div class="stat-label">Pontos Totais</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <div class="stat-number">85%</div>
                    <div class="stat-label">Progresso Médio</div>
                </div>
            </div>
        </div>

        <h2 class="mb-4 text-center" style="color: var(--primary-color); font-weight: 700;">
            🎮 Jogos Educativos
        </h2>

        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="game-card text-center">
                    <div class="game-icon">🔤</div>
                    <h3 class="game-title">Caça Letras</h3>
                    <p class="game-description">
                        Encontre letras específicas em meio a outras letras.
                        Desenvolve atenção e reconhecimento alfabético.
                    </p>
                    <button class="btn btn-play w-100" onclick="playGame('alphabet')">
                        Jogar Agora
                    </button>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="game-card text-center">
                    <div class="game-icon">🔢</div>
                    <h3 class="game-title">Conta Números</h3>
                    <p class="game-description">
                        Conte objetos na tela e selecione a quantidade correta.
                        Aprenda matemática básica de forma divertida.
                    </p>
                    <button class="btn btn-secondary w-100" disabled>
                        Em Breve
                    </button>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="game-card text-center">
                    <div class="game-icon">🌈</div>
                    <h3 class="game-title">Cores Mágicas</h3>
                    <p class="game-description">
                        Identifique e combine cores corretamente.
                        Desenvolve percepção visual e criatividade.
                    </p>
                    <button class="btn btn-secondary w-100" disabled>
                        Em Breve
                    </button>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="game-card text-center">
                    <div class="game-icon">🧩</div>
                    <h3 class="game-title">Quebra-Cabeça</h3>
                    <p class="game-description">
                        Monte quebra-cabeças temáticos infantis.
                        Desenvolve coordenação motora e lógica.
                    </p>
                    <button class="btn btn-secondary w-100" disabled>
                        Em Breve
                    </button>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="game-card text-center">
                    <div class="game-icon">🎵</div>
                    <h3 class="game-title">Ritmo Musical</h3>
                    <p class="game-description">
                        Siga o ritmo e repita sequências musicais.
                        Desenvolve senso rítmico e coordenação.
                    </p>
                    <button class="btn btn-secondary w-100" disabled>
                        Em Breve
                    </button>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="game-card text-center">
                    <div class="game-icon">🌍</div>
                    <h3 class="game-title">Mundo Animal</h3>
                    <p class="game-description">
                        Conheça animais de diferentes continentes.
                        Aprenda geografia e biologia de forma lúdica.
                    </p>
                    <button class="btn btn-secondary w-100" disabled>
                        Em Breve
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function playGame(gameId) {
            window.location.href = `/games/${gameId}`;
        }
    </script>
</body>
</html>