<section class="mb-4">
    <span class="section-chip section-chip-soft">Gestao infantil</span>
    <h1 class="display-6 mt-2 mb-2">Criancas</h1>
    <p class="text-muted mb-0">Fluxo inicial para cadastro e consulta local das criancas vinculadas ao responsavel.</p>
</section>

<section class="row g-4">
    <div class="col-lg-5">
        <article class="card border-0 shadow-sm rounded-5">
            <div class="card-body p-4">
                <h2 class="h4 mb-3">Nova crianca</h2>
                <form method="post" action="<?= e(app_url('children')) ?>" class="d-grid gap-3">
                    <div>
                        <label class="form-label">Nome</label>
                        <input type="text" name="name" class="form-control rounded-4" value="<?= e(old('name')) ?>" required>
                    </div>
                    <div>
                        <label class="form-label">Data de nascimento</label>
                        <input type="date" name="birth_date" class="form-control rounded-4" value="<?= e(old('birth_date')) ?>" required>
                    </div>
                    <div>
                        <label class="form-label">Genero</label>
                        <select name="gender" class="form-select rounded-4">
                            <option value="female" <?= old('gender') === 'female' ? 'selected' : '' ?>>Feminino</option>
                            <option value="male" <?= old('gender') === 'male' ? 'selected' : '' ?>>Masculino</option>
                            <option value="other" <?= old('gender', 'other') === 'other' ? 'selected' : '' ?>>Outro</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-bubble">Cadastrar crianca</button>
                </form>
            </div>
        </article>
    </div>
    <div class="col-lg-7">
        <article class="card border-0 shadow-sm rounded-5 h-100">
            <div class="card-body p-4">
                <h2 class="h4 mb-3">Lista atual</h2>
                <div class="d-grid gap-3">
                    <?php foreach ($children as $child): ?>
                        <div class="child-card">
                            <div>
                                <strong><?= e($child['name']) ?></strong>
                                <p class="mb-0 text-muted small"><?= e((string) age_from_birth_date($child['birth_date'])) ?> anos • Nivel <?= e((string) $child['level']) ?></p>
                            </div>
                            <div class="text-end">
                                <span class="stars-pill"><?= e((string) $child['stars']) ?> estrelas</span>
                                <p class="mb-0 text-muted small mt-2">Jogo favorito: <?= e($child['favorite_game']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </article>
    </div>
</section>
