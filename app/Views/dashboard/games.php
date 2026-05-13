<section class="mb-4">
    <span class="section-chip section-chip-soft">Biblioteca de jogos</span>
    <h1 class="display-6 mt-2 mb-2">Jogos da Fase 1</h1>
    <p class="text-muted mb-0">Catalogo inicial com foco em alfabetizacao, memoria e coordenacao motora.</p>
</section>

<section class="row g-4">
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
                </div>
            </article>
        </div>
    <?php endforeach; ?>
</section>
