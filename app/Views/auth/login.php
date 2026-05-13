<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-6">
                <section class="auth-side p-4 p-lg-5 h-100">
                    <span class="section-chip">Acesso demo</span>
                    <h1 class="display-6 fw-bold mt-3">Entre e explore a estrutura inicial do sistema.</h1>
                    <p class="mt-3 mb-4">Use uma das contas abaixo para navegar pela plataforma, cadastrar criancas e validar o fluxo inicial.</p>
                    <div class="demo-user-list d-grid gap-3">
                        <div class="demo-user-card">
                            <strong>Responsavel</strong>
                            <span>parent@kids.local</span>
                            <span>Senha: 123456</span>
                        </div>
                        <div class="demo-user-card">
                            <strong>Administrador</strong>
                            <span>admin@kids.local</span>
                            <span>Senha: 123456</span>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-6">
                <section class="card border-0 shadow-lg rounded-5 p-4 p-lg-5 h-100">
                    <h2 class="h3 mb-4">Entrar</h2>
                    <form method="post" action="<?= e(app_url('login')) ?>" class="d-grid gap-3">
                        <div>
                            <label class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control form-control-lg rounded-4" value="<?= e(old('email')) ?>" placeholder="parent@kids.local" required>
                        </div>
                        <div>
                            <label class="form-label">Senha</label>
                            <input type="password" name="password" class="form-control form-control-lg rounded-4" placeholder="123456" required>
                        </div>
                        <button type="submit" class="btn btn-bubble btn-lg">Acessar plataforma</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
