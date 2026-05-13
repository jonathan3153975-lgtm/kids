# DOCUMENTO 03 — ESTRUTURA DETALHADA DO BANCO DE DADOS
# Plataforma Educacional Infantil Gamificada

---

# 1. OBJETIVO DO BANCO DE DADOS

O banco de dados será responsável por armazenar:

- usuários;
- crianças;
- progresso;
- jogos;
- fases;
- assinaturas;
- pagamentos;
- gamificação;
- relatórios;
- métricas.

---

# 2. TECNOLOGIA DEFINIDA

| Item | Tecnologia |
|---|---|
| Banco de dados | MariaDB |
| Versão mínima | 10.6+ |
| Charset | utf8mb4 |
| Collation | utf8mb4_unicode_ci |

---

# 3. CONFIGURAÇÃO INICIAL

# Criação do banco

```sql id="xasvya"
CREATE DATABASE kidsystem
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

4. PADRÕES DE MODELAGEM
Convenções
Tabelas
nomes em snake_case;
plural.
Campos
snake_case;
sem espaços;
sem caracteres especiais.
Chaves primárias
id BIGINT AUTO_INCREMENT.
Datas
created_at;
updated_at.
5. DIAGRAMA GERAL DAS ENTIDADES
users
├── children
│   ├── child_progress
│   ├── child_rewards
│   ├── child_achievements
│   └── child_sessions
│
├── subscriptions
├── payments
│
games
├── game_categories
├── game_levels
├── game_phases
│
progress
rewards
achievements
missions
6. TABELA: users
Objetivo

Armazenar usuários do sistema.

Estrutura
CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    role ENUM(
        'admin',
        'parent',
        'teacher'
    ) DEFAULT 'parent',

    avatar VARCHAR(255) NULL,

    phone VARCHAR(20) NULL,

    status ENUM(
        'active',
        'inactive',
        'blocked'
    ) DEFAULT 'active',

    email_verified_at TIMESTAMP NULL,

    remember_token VARCHAR(255) NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
7. TABELA: children
Objetivo

Armazenar crianças vinculadas aos responsáveis.

Estrutura
CREATE TABLE children (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT NOT NULL,

    name VARCHAR(120) NOT NULL,

    birth_date DATE NOT NULL,

    gender ENUM(
        'male',
        'female',
        'other'
    ) NULL,

    avatar VARCHAR(255) NULL,

    level INT DEFAULT 1,

    experience_points INT DEFAULT 0,

    coins INT DEFAULT 0,

    stars INT DEFAULT 0,

    total_play_time INT DEFAULT 0,

    last_access TIMESTAMP NULL,

    status ENUM(
        'active',
        'inactive'
    ) DEFAULT 'active',

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_children_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
8. TABELA: game_categories
Objetivo

Categorias pedagógicas dos jogos.

Estrutura
CREATE TABLE game_categories (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    slug VARCHAR(100) NOT NULL UNIQUE,

    description TEXT NULL,

    min_age INT NULL,

    max_age INT NULL,

    icon VARCHAR(255) NULL,

    color VARCHAR(20) NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
9. TABELA: games
Objetivo

Armazenar os jogos da plataforma.

Estrutura
CREATE TABLE games (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    category_id BIGINT NOT NULL,

    title VARCHAR(150) NOT NULL,

    slug VARCHAR(150) NOT NULL UNIQUE,

    description TEXT NULL,

    thumbnail VARCHAR(255) NULL,

    game_path VARCHAR(255) NOT NULL,

    difficulty ENUM(
        'easy',
        'medium',
        'hard'
    ) DEFAULT 'easy',

    minimum_age INT DEFAULT 2,

    maximum_age INT DEFAULT 12,

    premium BOOLEAN DEFAULT FALSE,

    featured BOOLEAN DEFAULT FALSE,

    status ENUM(
        'draft',
        'published',
        'archived'
    ) DEFAULT 'draft',

    total_plays INT DEFAULT 0,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_games_category
        FOREIGN KEY (category_id)
        REFERENCES game_categories(id)
        ON DELETE CASCADE
);
10. TABELA: game_levels
Objetivo

Níveis internos dos jogos.

Estrutura
CREATE TABLE game_levels (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    game_id BIGINT NOT NULL,

    title VARCHAR(120) NOT NULL,

    level_number INT NOT NULL,

    difficulty ENUM(
        'easy',
        'medium',
        'hard'
    ) DEFAULT 'easy',

    minimum_score INT DEFAULT 0,

    reward_coins INT DEFAULT 0,

    reward_stars INT DEFAULT 0,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_levels_game
        FOREIGN KEY (game_id)
        REFERENCES games(id)
        ON DELETE CASCADE
);
11. TABELA: game_phases
Objetivo

Fases dos níveis dos jogos.

Estrutura
CREATE TABLE game_phases (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    game_level_id BIGINT NOT NULL,

    phase_number INT NOT NULL,

    title VARCHAR(150) NULL,

    configuration JSON NULL,

    reward_points INT DEFAULT 0,

    reward_coins INT DEFAULT 0,

    reward_stars INT DEFAULT 0,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_phase_level
        FOREIGN KEY (game_level_id)
        REFERENCES game_levels(id)
        ON DELETE CASCADE
);
12. TABELA: child_progress
Objetivo

Salvar progresso da criança nos jogos.

Estrutura
CREATE TABLE child_progress (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    child_id BIGINT NOT NULL,

    game_id BIGINT NOT NULL,

    game_level_id BIGINT NULL,

    phase_id BIGINT NULL,

    score INT DEFAULT 0,

    stars INT DEFAULT 0,

    errors_count INT DEFAULT 0,

    hits_count INT DEFAULT 0,

    play_time INT DEFAULT 0,

    completed BOOLEAN DEFAULT FALSE,

    completed_at TIMESTAMP NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_progress_child
        FOREIGN KEY (child_id)
        REFERENCES children(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_progress_game
        FOREIGN KEY (game_id)
        REFERENCES games(id)
        ON DELETE CASCADE
);
13. TABELA: achievements
Objetivo

Conquistas disponíveis.

Estrutura
CREATE TABLE achievements (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(150) NOT NULL,

    description TEXT NULL,

    icon VARCHAR(255) NULL,

    reward_coins INT DEFAULT 0,

    reward_stars INT DEFAULT 0,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
14. TABELA: child_achievements
Objetivo

Relacionar conquistas desbloqueadas.

Estrutura
CREATE TABLE child_achievements (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    child_id BIGINT NOT NULL,

    achievement_id BIGINT NOT NULL,

    unlocked_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_child_achievement_child
        FOREIGN KEY (child_id)
        REFERENCES children(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_child_achievement_achievement
        FOREIGN KEY (achievement_id)
        REFERENCES achievements(id)
        ON DELETE CASCADE
);
15. TABELA: rewards
Objetivo

Itens de recompensa.

Estrutura
CREATE TABLE rewards (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(120) NOT NULL,

    description TEXT NULL,

    type ENUM(
        'avatar',
        'theme',
        'badge',
        'coin'
    ) DEFAULT 'badge',

    icon VARCHAR(255) NULL,

    cost_coins INT DEFAULT 0,

    premium BOOLEAN DEFAULT FALSE,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
16. TABELA: child_rewards
Objetivo

Recompensas desbloqueadas pela criança.

Estrutura
CREATE TABLE child_rewards (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    child_id BIGINT NOT NULL,

    reward_id BIGINT NOT NULL,

    unlocked_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_child_reward_child
        FOREIGN KEY (child_id)
        REFERENCES children(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_child_reward_reward
        FOREIGN KEY (reward_id)
        REFERENCES rewards(id)
        ON DELETE CASCADE
);
17. TABELA: subscriptions
Objetivo

Assinaturas dos usuários.

Estrutura
CREATE TABLE subscriptions (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT NOT NULL,

    plan ENUM(
        'free',
        'premium',
        'family',
        'school'
    ) DEFAULT 'free',

    status ENUM(
        'active',
        'pending',
        'expired',
        'cancelled'
    ) DEFAULT 'pending',

    amount DECIMAL(10,2) DEFAULT 0.00,

    starts_at TIMESTAMP NULL,

    expires_at TIMESTAMP NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_subscription_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
18. TABELA: payments
Objetivo

Controle financeiro e pagamentos.

Estrutura
CREATE TABLE payments (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    subscription_id BIGINT NOT NULL,

    provider ENUM(
        'mercadopago',
        'stripe',
        'paypal'
    ) DEFAULT 'mercadopago',

    provider_payment_id VARCHAR(255) NULL,

    amount DECIMAL(10,2) NOT NULL,

    currency VARCHAR(10) DEFAULT 'BRL',

    status ENUM(
        'pending',
        'approved',
        'rejected',
        'refunded'
    ) DEFAULT 'pending',

    paid_at TIMESTAMP NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_payment_subscription
        FOREIGN KEY (subscription_id)
        REFERENCES subscriptions(id)
        ON DELETE CASCADE
);
19. TABELA: missions
Objetivo

Missões diárias e desafios.

Estrutura
CREATE TABLE missions (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(150) NOT NULL,

    description TEXT NULL,

    reward_coins INT DEFAULT 0,

    reward_stars INT DEFAULT 0,

    active BOOLEAN DEFAULT TRUE,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
20. TABELA: child_missions
Objetivo

Controle das missões realizadas.

Estrutura
CREATE TABLE child_missions (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    child_id BIGINT NOT NULL,

    mission_id BIGINT NOT NULL,

    completed BOOLEAN DEFAULT FALSE,

    completed_at TIMESTAMP NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_child_mission_child
        FOREIGN KEY (child_id)
        REFERENCES children(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_child_mission_mission
        FOREIGN KEY (mission_id)
        REFERENCES missions(id)
        ON DELETE CASCADE
);
21. TABELA: child_sessions
Objetivo

Controle de sessões e tempo de uso.

Estrutura
CREATE TABLE child_sessions (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    child_id BIGINT NOT NULL,

    started_at TIMESTAMP NULL,

    ended_at TIMESTAMP NULL,

    duration_seconds INT DEFAULT 0,

    device VARCHAR(100) NULL,

    ip_address VARCHAR(50) NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_child_session_child
        FOREIGN KEY (child_id)
        REFERENCES children(id)
        ON DELETE CASCADE
);
22. TABELA: parental_reports
Objetivo

Relatórios para responsáveis.

Estrutura
CREATE TABLE parental_reports (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    child_id BIGINT NOT NULL,

    total_games INT DEFAULT 0,

    total_time INT DEFAULT 0,

    average_score DECIMAL(10,2) DEFAULT 0,

    strongest_area VARCHAR(100) NULL,

    weakest_area VARCHAR(100) NULL,

    generated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_parental_report_child
        FOREIGN KEY (child_id)
        REFERENCES children(id)
        ON DELETE CASCADE
);
23. TABELA: system_logs
Objetivo

Registrar eventos do sistema.

Estrutura
CREATE TABLE system_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT NULL,

    type VARCHAR(100) NOT NULL,

    description TEXT NULL,

    ip_address VARCHAR(50) NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
);
24. ÍNDICES RECOMENDADOS
Objetivo

Melhorar performance.

Índices importantes
CREATE INDEX idx_users_email
ON users(email);

CREATE INDEX idx_games_category
ON games(category_id);

CREATE INDEX idx_progress_child
ON child_progress(child_id);

CREATE INDEX idx_progress_game
ON child_progress(game_id);

CREATE INDEX idx_subscription_user
ON subscriptions(user_id);
25. RELACIONAMENTOS PRINCIPAIS
users 1:N children

children 1:N child_progress

games 1:N game_levels

game_levels 1:N game_phases

children N:N achievements

children N:N rewards

users 1:N subscriptions

subscriptions 1:N payments
26. ESTRATÉGIA DE ESCALABILIDADE

O banco deverá suportar:

milhares de usuários;
múltiplos jogos;
expansão futura;
aplicativo mobile;
relatórios avançados;
IA adaptativa futuramente.
27. BOAS PRÁTICAS
Regras importantes
utilizar prepared statements;
utilizar índices;
evitar queries pesadas;
utilizar paginação;
utilizar soft delete futuramente;
separar logs do banco principal futuramente.
28. BACKUP E SEGURANÇA
Recomendações
backup diário;
backup incremental;
replicação futura;
criptografia de senhas;
proteção contra SQL Injection.
29. EXPANSÕES FUTURAS
Recursos planejados
IA pedagógica;
recomendação de jogos;
relatórios inteligentes;
ranking global;
sistema escolar;
múltiplos idiomas;
sistema offline.
30. OBJETIVO FINAL DO BANCO DE DADOS

Criar uma estrutura robusta, escalável e organizada, capaz de:

suportar crescimento da plataforma;
armazenar progresso pedagógico;
sustentar sistema gamificado;
permitir integração com aplicativos;
oferecer estabilidade para expansão futura.