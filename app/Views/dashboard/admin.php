<section class="mb-4">
    <span class="section-chip section-chip-soft">Painel administrativo</span>
    <h1 class="display-6 mt-2 mb-2">Visao operacional do MVP</h1>
    <p class="text-muted mb-0">Resumo inicial para administracao, assinaturas e desempenho do catalogo.</p>
</section>

<!-- Navigation Tabs -->
<section class="mb-4">
    <nav>
        <div class="nav nav-tabs border-0" id="adminTabs" role="tablist">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                <i class="bi bi-house-door me-2"></i>Visão Geral
            </button>
            <button class="nav-link" id="children-tab" data-bs-toggle="tab" data-bs-target="#children" type="button" role="tab" aria-controls="children" aria-selected="false">
                <i class="bi bi-people me-2"></i>Crianças
            </button>
            <button class="nav-link" id="games-tab" data-bs-toggle="tab" data-bs-target="#games" type="button" role="tab" aria-controls="games" aria-selected="false">
                <i class="bi bi-controller me-2"></i>Jogos
            </button>
            <button class="nav-link" id="plans-tab" data-bs-toggle="tab" data-bs-target="#plans" type="button" role="tab" aria-controls="plans" aria-selected="false">
                <i class="bi bi-star me-2"></i>Planos
            </button>
        </div>
    </nav>
</section>

<!-- Tab Content -->
<section class="tab-content" id="adminTabContent">
    <!-- Overview Tab -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <article class="metric-card bg-sun h-100">
                    <span>Total de criancas</span>
                    <strong><?= e((string) count($children)) ?></strong>
                </article>
            </div>
            <div class="col-md-4">
                <article class="metric-card bg-mint h-100">
                    <span>Total de jogos</span>
                    <strong><?= e((string) count($games)) ?></strong>
                </article>
            </div>
            <div class="col-md-4">
                <article class="metric-card bg-coral h-100">
                    <span>Planos ativos</span>
                    <strong><?= e((string) count($plans)) ?></strong>
                </article>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <article class="card border-0 shadow-sm rounded-5">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-3">Planos cadastrados</h2>
                        <div class="d-grid gap-3">
                            <?php foreach ($plans as $plan): ?>
                                <div class="highlight-item">
                                    <div>
                                        <strong><?= e($plan['name']) ?></strong>
                                        <p class="mb-0 text-muted small"><?= e($plan['description']) ?></p>
                                    </div>
                                    <span class="stars-pill"><?= e($plan['price']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-5">
                <article class="card border-0 shadow-sm rounded-5 h-100">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-3">Proximos passos sugeridos</h2>
                        <ul class="list-unstyled d-grid gap-3 mb-0 text-muted">
                            <li>Conectar formularios a MariaDB com PDO e migrations.</li>
                            <li>Substituir autenticacao demo por JWT real na API.</li>
                            <li>Integrar jogos Phaser.js dentro da pasta games.</li>
                            <li>Adicionar pagamentos via Mercado Pago ou Stripe.</li>
                        </ul>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <!-- Children Tab -->
    <div class="tab-pane fade" id="children" role="tabpanel" aria-labelledby="children-tab">
        <article class="card border-0 shadow-sm rounded-5">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 mb-0">Gerenciamento de Criancas</h2>
                    <a href="<?= e(app_url('children')) ?>" class="btn btn-bubble">Cadastrar Nova Crianca</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data de Nascimento</th>
                                <th>Genero</th>
                                <th>Estrelas</th>
                                <th>Moedas</th>
                                <th>Acoes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($children as $child): ?>
                                <tr>
                                    <td><?= e($child['name']) ?></td>
                                    <td><?= e(date('d/m/Y', strtotime($child['birth_date']))) ?></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= e(ucfirst($child['gender'] ?? 'other')) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            ⭐ <?= e((string) ($child['stars'] ?? 0)) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            🪙 <?= e((string) ($child['coins'] ?? 0)) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">Editar</button>
                                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </div>

    <!-- Games Tab -->
    <div class="tab-pane fade" id="games" role="tabpanel" aria-labelledby="games-tab">
        <div class="row g-4">
            <?php foreach ($games as $game): ?>
                <div class="col-md-6 col-xl-4">
                    <article class="card border-0 shadow-sm rounded-5 h-100 overflow-hidden">
                        <div class="game-banner badge-<?= e($game['badge_color']) ?>"></div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                <div>
                                    <span class="badge badge-<?= e($game['badge_color']) ?> mb-2"><?= e($game['category']) ?></span>
                                    <h2 class="h4 mb-0"><?= e($game['title']) ?></h2>
                                </div>
                                <?php if ($game['premium']): ?>
                                    <span class="badge text-bg-dark rounded-pill">Premium</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-muted"><?= e($game['description']) ?></p>
                            <div class="game-meta">
                                <span><?= e(ucfirst($game['difficulty'])) ?></span>
                                <span><?= e((string) $game['minimum_age']) ?>-<?= e((string) $game['maximum_age']) ?> anos</span>
                                <span><?= e((string) $game['plays']) ?> partidas</span>
                            </div>
                            <div class="mt-3">
                                <a href="<?= e(app_url('games/' . $game['slug'])) ?>" class="btn btn-bubble w-100">
                                    Jogar Agora
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Plans Tab -->
    <div class="tab-pane fade" id="plans" role="tabpanel" aria-labelledby="plans-tab">
        <article class="card border-0 shadow-sm rounded-5">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 mb-0">Gerenciamento de Planos</h2>
                    <button class="btn btn-bubble">Criar Novo Plano</button>
                </div>
                <div class="d-grid gap-3">
                    <?php foreach ($plans as $plan): ?>
                        <div class="highlight-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong><?= e($plan['name']) ?></strong>
                                    <p class="mb-0 text-muted small"><?= e($plan['description']) ?></p>
                                </div>
                                <div class="text-end">
                                    <span class="stars-pill mb-2 d-block"><?= e($plan['price']) ?></span>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary">Editar</button>
                                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </article>
    </div>
</section>
