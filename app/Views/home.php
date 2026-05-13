<section class="hero-card p-4 p-lg-5 mb-4 mb-lg-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <span class="section-chip">Aprender brincando</span>
            <h1 class="display-5 fw-bold mt-3 mb-3">Plataforma educacional infantil com visual alegre e estrutura pronta para evoluir.</h1>
            <p class="lead mb-4">Base inicial com autenticacao demo, painel responsivo, cadastro de criancas, catalogo de jogos e API REST para o MVP.</p>
            <div class="d-flex flex-wrap gap-3">
                <a href="<?= e(app_url('login')) ?>" class="btn btn-bubble btn-lg">Entrar no sistema</a>
                <a href="<?= e(app_url('api/v1/health')) ?>" class="btn btn-outline-light btn-lg rounded-pill px-4">API Health</a>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="playful-panel">
                <div class="orbit orbit-a"></div>
                <div class="orbit orbit-b"></div>
                <div class="mini-stat bg-sun">
                    <strong>3 jogos</strong>
                    <span>fase 1</span>
                </div>
                <div class="mini-stat bg-mint">
                    <strong>API REST</strong>
                    <span>rotas iniciais</span>
                </div>
                <div class="mini-stat bg-coral">
                    <strong>Bootstrap</strong>
                    <span>tema infantil</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="section-chip section-chip-soft">Jogos iniciais</span>
            <h2 class="h3 mt-2 mb-0">Catalogo do MVP</h2>
        </div>
    </div>
    <div class="row g-4">
        <?php foreach ($games as $game): ?>
            <div class="col-md-6 col-xl-4">
                <article class="card game-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <span class="badge badge-<?= e($game['badge_color']) ?> mb-3"><?= e($game['category']) ?></span>
                        <h3 class="h4 mb-2"><?= e($game['title']) ?></h3>
                        <p class="text-muted mb-4"><?= e($game['description']) ?></p>
                        <div class="d-flex justify-content-between text-muted small">
                            <span><?= e(ucfirst($game['difficulty'])) ?></span>
                            <span><?= e((string) $game['plays']) ?> partidas</span>
                        </div>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section>
    <div class="row g-4">
        <?php foreach ($plans as $plan): ?>
            <div class="col-md-4">
                <article class="pricing-card h-100 p-4">
                    <span class="section-chip section-chip-soft mb-3"><?= e($plan['name']) ?></span>
                    <h3 class="display-6 mb-2"><?= e($plan['price']) ?></h3>
                    <p class="mb-0 text-muted"><?= e($plan['description']) ?></p>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
