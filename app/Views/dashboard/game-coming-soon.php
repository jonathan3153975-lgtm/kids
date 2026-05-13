<section class="mb-4">
    <span class="section-chip section-chip-soft">Jogo em desenvolvimento</span>
    <h1 class="display-6 mt-2 mb-2">Em breve: <?= e($game['title']) ?></h1>
    <p class="text-muted mb-0">Este jogo está sendo desenvolvido e estará disponível em breve!</p>
</section>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <article class="card border-0 shadow-sm rounded-5 text-center">
            <div class="card-body p-5">
                <div class="game-banner badge-<?= e($game['badge_color']) ?> mb-4" style="height: 200px; border-radius: 1rem;"></div>

                <div class="mb-4">
                    <span class="badge badge-<?= e($game['badge_color']) ?> mb-3 fs-6 px-3 py-2">
                        <?= e($game['category']) ?>
                    </span>
                    <h2 class="h3 mb-3"><?= e($game['title']) ?></h2>
                    <p class="text-muted lead mb-4"><?= e($game['description']) ?></p>
                </div>

                <div class="game-meta mb-4">
                    <span class="me-3">
                        <i class="bi bi-bar-chart me-1"></i>
                        <?= e(ucfirst($game['difficulty'])) ?>
                    </span>
                    <span class="me-3">
                        <i class="bi bi-person me-1"></i>
                        <?= e((string) $game['minimum_age']) ?>-<?= e((string) $game['maximum_age']) ?> anos
                    </span>
                    <span>
                        <i class="bi bi-play-circle me-1"></i>
                        <?= e((string) $game['plays']) ?> partidas
                    </span>
                </div>

                <?php if ($game['premium']): ?>
                    <div class="alert alert-warning rounded-4 mb-4">
                        <i class="bi bi-star-fill me-2"></i>
                        Este é um jogo Premium - disponível nos planos pagos
                    </div>
                <?php endif; ?>

                <div class="d-grid gap-3">
                    <button class="btn btn-bubble btn-lg" disabled>
                        <i class="bi bi-tools me-2"></i>
                        Em desenvolvimento
                    </button>

                    <a href="<?= e(app_url('games')) ?>" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Voltar aos jogos
                    </a>
                </div>

                <div class="mt-4 pt-4 border-top">
                    <p class="text-muted small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Fique ligado nas atualizações! Novos jogos são adicionados regularmente.
                    </p>
                </div>
            </div>
        </article>
    </div>
</div>