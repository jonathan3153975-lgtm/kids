<section class="mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3">
        <div>
            <span class="section-chip section-chip-soft">Painel inicial</span>
            <h1 class="display-6 mt-2 mb-2">Ola, <?= e(current_user()['name'] ?? 'Visitante') ?>.</h1>
            <p class="text-muted mb-0">Resumo rapido para acompanhar criancas, jogos e engajamento inicial.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= e(app_url('children')) ?>" class="btn btn-bubble">Cadastrar crianca</a>
            <a href="<?= e(app_url('games')) ?>" class="btn btn-bubble btn-bubble-secondary">Ver jogos</a>
        </div>
    </div>
</section>

<section class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <article class="metric-card bg-sun h-100">
            <span>Criancas</span>
            <strong><?= e((string) $metrics['children']) ?></strong>
        </article>
    </div>
    <div class="col-sm-6 col-xl-3">
        <article class="metric-card bg-mint h-100">
            <span>Jogos</span>
            <strong><?= e((string) $metrics['games']) ?></strong>
        </article>
    </div>
    <div class="col-sm-6 col-xl-3">
        <article class="metric-card bg-coral h-100">
            <span>Estrelas</span>
            <strong><?= e((string) $metrics['stars']) ?></strong>
        </article>
    </div>
    <div class="col-sm-6 col-xl-3">
        <article class="metric-card bg-sky h-100">
            <span>Moedas</span>
            <strong><?= e((string) $metrics['coins']) ?></strong>
        </article>
    </div>
</section>

<section class="row g-4">
    <div class="col-lg-7">
        <article class="card border-0 shadow-sm rounded-5 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 mb-0">Criancas cadastradas</h2>
                    <a href="<?= e(app_url('children')) ?>" class="link-offset-2">Gerenciar</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Idade</th>
                                <th>Nivel</th>
                                <th>Favorito</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($children as $child): ?>
                                <tr>
                                    <td><?= e($child['name']) ?></td>
                                    <td><?= e((string) age_from_birth_date($child['birth_date'])) ?> anos</td>
                                    <td><?= e((string) $child['level']) ?></td>
                                    <td><?= e($child['favorite_game']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </div>
    <div class="col-lg-5">
        <article class="card border-0 shadow-sm rounded-5 h-100">
            <div class="card-body p-4">
                <h2 class="h4 mb-3">Jogos em destaque</h2>
                <div class="d-grid gap-3">
                    <?php foreach (array_slice($games, 0, 3) as $game): ?>
                        <div class="highlight-item">
                            <div>
                                <strong><?= e($game['title']) ?></strong>
                                <p class="mb-0 text-muted small"><?= e($game['description']) ?></p>
                            </div>
                            <span class="badge rounded-pill text-bg-light"><?= e($game['category']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </article>
    </div>
</section>
