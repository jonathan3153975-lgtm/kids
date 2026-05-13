CREATE DATABASE IF NOT EXISTS kidsystem
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE kidsystem;

CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'parent', 'teacher') NOT NULL DEFAULT 'parent',
    avatar VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    status ENUM('active', 'inactive', 'blocked') NOT NULL DEFAULT 'active',
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS refresh_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    token_hash VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    revoked_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_refresh_tokens_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_refresh_tokens_hash (token_hash)
);

CREATE TABLE IF NOT EXISTS password_resets (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    token_hash VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    used_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_password_resets_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_password_resets_hash (token_hash)
);

CREATE TABLE IF NOT EXISTS children (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(120) NOT NULL,
    birth_date DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NULL,
    avatar VARCHAR(255) NULL,
    level INT NOT NULL DEFAULT 1,
    experience_points INT NOT NULL DEFAULT 0,
    coins INT NOT NULL DEFAULT 0,
    stars INT NOT NULL DEFAULT 0,
    total_play_time INT NOT NULL DEFAULT 0,
    last_access TIMESTAMP NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_children_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS game_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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

CREATE TABLE IF NOT EXISTS games (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    description TEXT NULL,
    thumbnail VARCHAR(255) NULL,
    game_path VARCHAR(255) NOT NULL,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'easy',
    minimum_age INT NOT NULL DEFAULT 2,
    maximum_age INT NOT NULL DEFAULT 12,
    premium BOOLEAN NOT NULL DEFAULT FALSE,
    featured BOOLEAN NOT NULL DEFAULT FALSE,
    status ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'draft',
    total_plays INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_games_category
        FOREIGN KEY (category_id) REFERENCES game_categories(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS game_levels (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    game_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(120) NOT NULL,
    level_number INT NOT NULL,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'easy',
    minimum_score INT NOT NULL DEFAULT 0,
    reward_coins INT NOT NULL DEFAULT 0,
    reward_stars INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_levels_game
        FOREIGN KEY (game_id) REFERENCES games(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_game_levels_number (game_id, level_number)
);

CREATE TABLE IF NOT EXISTS game_phases (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    game_level_id BIGINT UNSIGNED NOT NULL,
    phase_number INT NOT NULL,
    title VARCHAR(150) NULL,
    configuration JSON NULL,
    reward_points INT NOT NULL DEFAULT 0,
    reward_coins INT NOT NULL DEFAULT 0,
    reward_stars INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_phase_level
        FOREIGN KEY (game_level_id) REFERENCES game_levels(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_game_phase_number (game_level_id, phase_number)
);

CREATE TABLE IF NOT EXISTS child_progress (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    child_id BIGINT UNSIGNED NOT NULL,
    game_id BIGINT UNSIGNED NOT NULL,
    game_level_id BIGINT UNSIGNED NULL,
    phase_id BIGINT UNSIGNED NULL,
    score INT NOT NULL DEFAULT 0,
    stars INT NOT NULL DEFAULT 0,
    errors_count INT NOT NULL DEFAULT 0,
    hits_count INT NOT NULL DEFAULT 0,
    play_time INT NOT NULL DEFAULT 0,
    completed BOOLEAN NOT NULL DEFAULT FALSE,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_progress_child
        FOREIGN KEY (child_id) REFERENCES children(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_progress_game
        FOREIGN KEY (game_id) REFERENCES games(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_progress_level
        FOREIGN KEY (game_level_id) REFERENCES game_levels(id)
        ON DELETE SET NULL,
    CONSTRAINT fk_progress_phase
        FOREIGN KEY (phase_id) REFERENCES game_phases(id)
        ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS achievements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NULL,
    icon VARCHAR(255) NULL,
    reward_coins INT NOT NULL DEFAULT 0,
    reward_stars INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS child_achievements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    child_id BIGINT UNSIGNED NOT NULL,
    achievement_id BIGINT UNSIGNED NOT NULL,
    unlocked_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_child_achievement_child
        FOREIGN KEY (child_id) REFERENCES children(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_child_achievement_achievement
        FOREIGN KEY (achievement_id) REFERENCES achievements(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_child_achievement (child_id, achievement_id)
);

CREATE TABLE IF NOT EXISTS rewards (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(120) NOT NULL,
    description TEXT NULL,
    type ENUM('avatar', 'theme', 'badge', 'coin') NOT NULL DEFAULT 'badge',
    icon VARCHAR(255) NULL,
    cost_coins INT NOT NULL DEFAULT 0,
    premium BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS child_rewards (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    child_id BIGINT UNSIGNED NOT NULL,
    reward_id BIGINT UNSIGNED NOT NULL,
    unlocked_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_child_reward_child
        FOREIGN KEY (child_id) REFERENCES children(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_child_reward_reward
        FOREIGN KEY (reward_id) REFERENCES rewards(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_child_reward (child_id, reward_id)
);

CREATE TABLE IF NOT EXISTS plans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    billing_cycle ENUM('monthly', 'quarterly', 'yearly') NOT NULL DEFAULT 'monthly',
    max_children INT NOT NULL DEFAULT 1,
    description TEXT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS subscriptions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    plan_id BIGINT UNSIGNED NOT NULL,
    status ENUM('active', 'pending', 'expired', 'cancelled') NOT NULL DEFAULT 'pending',
    amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    provider VARCHAR(50) NULL,
    provider_reference VARCHAR(255) NULL,
    starts_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    cancelled_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_subscription_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_subscription_plan
        FOREIGN KEY (plan_id) REFERENCES plans(id)
        ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subscription_id BIGINT UNSIGNED NOT NULL,
    provider ENUM('mercadopago', 'stripe', 'paypal') NOT NULL DEFAULT 'mercadopago',
    provider_payment_id VARCHAR(255) NULL,
    provider_payload JSON NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'BRL',
    status ENUM('pending', 'approved', 'rejected', 'refunded') NOT NULL DEFAULT 'pending',
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_payment_subscription
        FOREIGN KEY (subscription_id) REFERENCES subscriptions(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS missions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NULL,
    reward_coins INT NOT NULL DEFAULT 0,
    reward_stars INT NOT NULL DEFAULT 0,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS child_missions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    child_id BIGINT UNSIGNED NOT NULL,
    mission_id BIGINT UNSIGNED NOT NULL,
    completed BOOLEAN NOT NULL DEFAULT FALSE,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_child_mission_child
        FOREIGN KEY (child_id) REFERENCES children(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_child_mission_mission
        FOREIGN KEY (mission_id) REFERENCES missions(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_child_mission (child_id, mission_id)
);

CREATE TABLE IF NOT EXISTS child_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    child_id BIGINT UNSIGNED NOT NULL,
    started_at TIMESTAMP NULL,
    ended_at TIMESTAMP NULL,
    duration_seconds INT NOT NULL DEFAULT 0,
    device VARCHAR(100) NULL,
    ip_address VARCHAR(50) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_child_session_child
        FOREIGN KEY (child_id) REFERENCES children(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS parental_reports (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    child_id BIGINT UNSIGNED NOT NULL,
    total_games INT NOT NULL DEFAULT 0,
    total_time INT NOT NULL DEFAULT 0,
    average_score DECIMAL(10,2) NOT NULL DEFAULT 0,
    strongest_area VARCHAR(100) NULL,
    weakest_area VARCHAR(100) NULL,
    generated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_parental_report_child
        FOREIGN KEY (child_id) REFERENCES children(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS system_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    type VARCHAR(100) NOT NULL,
    description TEXT NULL,
    ip_address VARCHAR(50) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_logs_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
);

-- NOVAS TABELAS PARA SUPORTE A JOGOS DETALHADOS
-- ================================================

CREATE TABLE IF NOT EXISTS alphabet_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    letter CHAR(1) NOT NULL UNIQUE,
    uppercase CHAR(1) NOT NULL,
    lowercase CHAR(1) NOT NULL,
    audio_url VARCHAR(255) NULL,
    image_url VARCHAR(255) NULL,
    category ENUM('vogal', 'consoante_simples', 'consoante_complexa') NOT NULL DEFAULT 'consoante_simples',
    difficulty_level INT NOT NULL DEFAULT 1,
    sound_variant ENUM('pura', 'silaba', 'palavra') NOT NULL DEFAULT 'pura',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS game_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    child_id BIGINT UNSIGNED NOT NULL,
    game_id BIGINT UNSIGNED NOT NULL,
    phase_id BIGINT UNSIGNED NULL,
    started_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ended_at TIMESTAMP NULL,
    duration_seconds INT NOT NULL DEFAULT 0,
    score INT NOT NULL DEFAULT 0,
    hits_count INT NOT NULL DEFAULT 0,
    errors_count INT NOT NULL DEFAULT 0,
    stars_earned INT NOT NULL DEFAULT 0,
    coins_earned INT NOT NULL DEFAULT 0,
    status ENUM('playing', 'completed', 'abandoned') NOT NULL DEFAULT 'playing',
    device VARCHAR(100) NULL,
    browser_info VARCHAR(255) NULL,
    completion_percentage INT NOT NULL DEFAULT 0,
    data_payload JSON NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_game_session_child
        FOREIGN KEY (child_id) REFERENCES children(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_game_session_game
        FOREIGN KEY (game_id) REFERENCES games(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_game_session_phase
        FOREIGN KEY (phase_id) REFERENCES game_phases(id)
        ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS game_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id BIGINT UNSIGNED NOT NULL,
    event_type ENUM('guess', 'error', 'skip', 'hint', 'timeout', 'phase_start', 'phase_end') NOT NULL DEFAULT 'guess',
    target_item VARCHAR(100) NULL,
    selected_item VARCHAR(100) NULL,
    is_correct BOOLEAN NOT NULL DEFAULT FALSE,
    time_elapsed INT NOT NULL DEFAULT 0,
    reaction_time INT NOT NULL DEFAULT 0,
    feedback_given VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_game_event_session
        FOREIGN KEY (session_id) REFERENCES game_sessions(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS game_audio_library (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    game_id BIGINT UNSIGNED NOT NULL,
    audio_type ENUM('letter_pronunciation', 'feedback_positive', 'feedback_negative', 'music', 'narration') NOT NULL,
    name VARCHAR(150) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    language VARCHAR(10) NOT NULL DEFAULT 'pt-BR',
    voice_actor VARCHAR(100) NULL,
    duration_ms INT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_game_audio_game
        FOREIGN KEY (game_id) REFERENCES games(id)
        ON DELETE CASCADE
);

-- ALTERAÇÕES EM TABELAS EXISTENTES
-- ==================================

ALTER TABLE games 
ADD COLUMN IF NOT EXISTS audio_enabled BOOLEAN NOT NULL DEFAULT TRUE,
ADD COLUMN IF NOT EXISTS has_tutorial BOOLEAN NOT NULL DEFAULT FALSE,
ADD COLUMN IF NOT EXISTS estimated_duration_minutes INT DEFAULT 5,
ADD COLUMN IF NOT EXISTS target_skills JSON NULL,
ADD COLUMN IF NOT EXISTS accessibility_features JSON NULL;

ALTER TABLE game_phases
ADD COLUMN IF NOT EXISTS available_letters JSON NULL,
ADD COLUMN IF NOT EXISTS target_letters JSON NULL,
ADD COLUMN IF NOT EXISTS time_limit_seconds INT DEFAULT 60,
ADD COLUMN IF NOT EXISTS max_errors_allowed INT DEFAULT 5,
ADD COLUMN IF NOT EXISTS passing_score INT DEFAULT 50,
ADD COLUMN IF NOT EXISTS difficulty_multiplier FLOAT DEFAULT 1.0;

ALTER TABLE game_levels
ADD COLUMN IF NOT EXISTS letter_set JSON NULL,
ADD COLUMN IF NOT EXISTS time_multiplier FLOAT DEFAULT 1.0;

ALTER TABLE child_progress
ADD COLUMN IF NOT EXISTS last_played_at TIMESTAMP NULL,
ADD COLUMN IF NOT EXISTS total_sessions INT NOT NULL DEFAULT 0,
ADD COLUMN IF NOT EXISTS best_score INT NOT NULL DEFAULT 0,
ADD COLUMN IF NOT EXISTS average_score DECIMAL(10,2) DEFAULT 0.00,
ADD COLUMN IF NOT EXISTS success_rate DECIMAL(5,2) DEFAULT 0.00,
ADD COLUMN IF NOT EXISTS favorite BOOLEAN NOT NULL DEFAULT FALSE,
ADD COLUMN IF NOT EXISTS streak_count INT NOT NULL DEFAULT 0,
ADD COLUMN IF NOT EXISTS recommendations JSON NULL;

-- ÍNDICES PARA PERFORMANCE
-- =========================

CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_children_user ON children(user_id);
CREATE INDEX idx_games_category ON games(category_id);
CREATE INDEX idx_progress_child ON child_progress(child_id);
CREATE INDEX idx_progress_game ON child_progress(game_id);
CREATE INDEX idx_progress_level ON child_progress(game_level_id);
CREATE INDEX idx_subscription_user ON subscriptions(user_id);
CREATE INDEX idx_payments_subscription ON payments(subscription_id);
CREATE INDEX idx_child_sessions_child ON child_sessions(child_id);
CREATE INDEX idx_game_sessions_child ON game_sessions(child_id);
CREATE INDEX idx_game_sessions_game ON game_sessions(game_id);
CREATE INDEX idx_game_events_session ON game_events(session_id);
CREATE INDEX idx_alphabet_items_category ON alphabet_items(category);
CREATE INDEX idx_alphabet_items_letter ON alphabet_items(letter);
CREATE INDEX idx_game_audio_game ON game_audio_library(game_id);

INSERT INTO users (name, email, password, role, avatar, status)
VALUES
    ('Ana Responsavel', 'parent@kids.local', '$2y$12$cfyKVz0S7QdgZym8L2pS/.IgRm/9POo6rBv0eZiAhfgGuGwq3vb4.', 'parent', 'AR', 'active'),
    ('Equipe Administrativa', 'admin@kids.local', '$2y$12$cfyKVz0S7QdgZym8L2pS/.IgRm/9POo6rBv0eZiAhfgGuGwq3vb4.', 'admin', 'AD', 'active')
ON DUPLICATE KEY UPDATE email = VALUES(email);

INSERT INTO children (user_id, name, birth_date, gender, level, experience_points, coins, stars, total_play_time, status)
VALUES
    (1, 'Luna', '2019-04-10', 'female', 4, 320, 140, 18, 1800, 'active'),
    (1, 'Theo', '2018-11-22', 'male', 5, 415, 185, 25, 2400, 'active')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO game_categories (name, slug, description, min_age, max_age, color)
VALUES
    ('Alfabetizacao', 'alfabetizacao', 'Jogos para letras, silabas, palavras e leitura inicial.', 4, 7, '#ffd94f'),
    ('Memoria', 'memoria', 'Atividades para memoria visual, pares e sequencias.', 4, 8, '#7ce7c4'),
    ('Coordenacao', 'coordenacao', 'Experiencias motoras com arraste, encaixe e toque.', 2, 5, '#ff6f6f')
ON DUPLICATE KEY UPDATE slug = VALUES(slug);

INSERT INTO games (category_id, title, slug, description, game_path, difficulty, minimum_age, maximum_age, premium, featured, status, total_plays)
VALUES
    (1, 'Caca Letras', 'caca-letras', 'Reconhecimento de letras e fonemas com feedback sonoro.', 'games/alphabet', 'easy', 4, 7, FALSE, TRUE, 'published', 142),
    (2, 'Memoria Infantil', 'memoria-infantil', 'Desafios por pares com dificuldade progressiva.', 'games/memory', 'medium', 4, 8, FALSE, TRUE, 'published', 96),
    (3, 'Arraste e Solte', 'arraste-e-solte', 'Jogo de coordenacao com objetos grandes e coloridos.', 'games/drag-drop', 'easy', 2, 5, TRUE, FALSE, 'published', 54)
ON DUPLICATE KEY UPDATE slug = VALUES(slug);

INSERT INTO game_levels (game_id, title, level_number, difficulty, minimum_score, reward_coins, reward_stars)
VALUES
    (1, 'Letras Iniciais', 1, 'easy', 50, 20, 3),
    (2, 'Cartas Coloridas', 1, 'easy', 40, 15, 2),
    (3, 'Formas Basicas', 1, 'easy', 30, 10, 2)
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO game_phases (game_level_id, phase_number, title, configuration, reward_points, reward_coins, reward_stars)
VALUES
    (1, 1, 'Encontre a Letra A', JSON_OBJECT('letters', JSON_ARRAY('A', 'B', 'C'), 'target', 'A'), 100, 10, 1),
    (2, 1, 'Memorize as Cartas', JSON_OBJECT('pairs', 4, 'theme', 'animals'), 80, 8, 1),
    (3, 1, 'Combine as Formas', JSON_OBJECT('items', 3, 'mode', 'dragdrop'), 70, 7, 1)
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO achievements (title, description, reward_coins, reward_stars)
VALUES
    ('Primeira Estrela', 'Complete a primeira fase.', 10, 1),
    ('Pequeno Explorador', 'Jogue tres atividades diferentes.', 25, 3)
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO rewards (title, description, type, cost_coins, premium)
VALUES
    ('Avatar Astronauta', 'Avatar divertido para o perfil.', 'avatar', 120, FALSE),
    ('Tema Arco-iris', 'Tema colorido para a plataforma.', 'theme', 180, TRUE)
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO plans (name, slug, price, billing_cycle, max_children, description, status)
VALUES
    ('Free', 'free', 0.00, 'monthly', 1, 'Plano gratuito com acesso introdutorio.', 'active'),
    ('Premium', 'premium', 29.90, 'monthly', 2, 'Plano individual com acesso completo.', 'active'),
    ('Familia', 'familia', 49.90, 'monthly', 4, 'Plano com suporte a varios perfis infantis.', 'active')
ON DUPLICATE KEY UPDATE slug = VALUES(slug);

INSERT INTO subscriptions (user_id, plan_id, status, amount, provider, starts_at, expires_at)
VALUES
    (1, 2, 'active', 29.90, 'mercadopago', CURRENT_TIMESTAMP, DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 30 DAY))
ON DUPLICATE KEY UPDATE amount = VALUES(amount);

INSERT INTO payments (subscription_id, provider, provider_payment_id, amount, currency, status, paid_at)
VALUES
    (1, 'mercadopago', 'MP-DEMO-001', 29.90, 'BRL', 'approved', CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE provider_payment_id = VALUES(provider_payment_id);

INSERT INTO missions (title, description, reward_coins, reward_stars, active)
VALUES
    ('Jogar 10 minutos', 'Complete 10 minutos de atividades no dia.', 15, 2, TRUE),
    ('Concluir 2 fases', 'Finalize duas fases diferentes.', 20, 3, TRUE)
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO child_missions (child_id, mission_id, completed, completed_at)
VALUES
    (1, 1, TRUE, CURRENT_TIMESTAMP),
    (2, 2, FALSE, NULL)
ON DUPLICATE KEY UPDATE completed = VALUES(completed);

INSERT INTO child_progress (child_id, game_id, game_level_id, phase_id, score, stars, errors_count, hits_count, play_time, completed, completed_at)
VALUES
    (1, 1, 1, 1, 92, 3, 1, 8, 420, TRUE, CURRENT_TIMESTAMP),
    (2, 2, 2, 2, 78, 2, 2, 6, 510, TRUE, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE score = VALUES(score);

INSERT INTO child_achievements (child_id, achievement_id)
VALUES
    (1, 1),
    (2, 2)
ON DUPLICATE KEY UPDATE unlocked_at = CURRENT_TIMESTAMP;

INSERT INTO child_rewards (child_id, reward_id)
VALUES
    (1, 1)
ON DUPLICATE KEY UPDATE unlocked_at = CURRENT_TIMESTAMP;

INSERT INTO child_sessions (child_id, started_at, ended_at, duration_seconds, device, ip_address)
VALUES
    (1, DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 30 MINUTE), CURRENT_TIMESTAMP, 1800, 'tablet', '127.0.0.1'),
    (2, DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 40 MINUTE), DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 5 MINUTE), 2100, 'desktop', '127.0.0.1');

INSERT INTO parental_reports (child_id, total_games, total_time, average_score, strongest_area, weakest_area)
VALUES
    (1, 8, 1800, 91.50, 'Alfabetizacao', 'Memoria'),
    (2, 9, 2400, 84.20, 'Memoria', 'Coordenacao')
ON DUPLICATE KEY UPDATE average_score = VALUES(average_score);

INSERT INTO system_logs (user_id, type, description, ip_address)
VALUES
    (1, 'login', 'Usuario demo autenticado.', '127.0.0.1'),
    (2, 'admin_access', 'Administrador acessou o painel.', '127.0.0.1');

-- DADOS PARA ALPHABET_ITEMS
-- ==========================

INSERT INTO alphabet_items (letter, uppercase, lowercase, category, difficulty_level, sound_variant)
VALUES
    ('A', 'A', 'a', 'vogal', 1, 'pura'),
    ('B', 'B', 'b', 'consoante_simples', 1, 'pura'),
    ('C', 'C', 'c', 'consoante_simples', 1, 'pura'),
    ('D', 'D', 'd', 'consoante_simples', 1, 'pura'),
    ('E', 'E', 'e', 'vogal', 1, 'pura'),
    ('F', 'F', 'f', 'consoante_simples', 2, 'pura'),
    ('G', 'G', 'g', 'consoante_simples', 2, 'pura'),
    ('H', 'H', 'h', 'consoante_simples', 2, 'pura'),
    ('I', 'I', 'i', 'vogal', 1, 'pura'),
    ('J', 'J', 'j', 'consoante_simples', 2, 'pura'),
    ('K', 'K', 'k', 'consoante_simples', 3, 'pura'),
    ('L', 'L', 'l', 'consoante_simples', 2, 'pura'),
    ('M', 'M', 'm', 'consoante_simples', 1, 'pura'),
    ('N', 'N', 'n', 'consoante_simples', 1, 'pura'),
    ('O', 'O', 'o', 'vogal', 1, 'pura'),
    ('P', 'P', 'p', 'consoante_simples', 1, 'pura'),
    ('Q', 'Q', 'q', 'consoante_complexa', 3, 'pura'),
    ('R', 'R', 'r', 'consoante_simples', 2, 'pura'),
    ('S', 'S', 's', 'consoante_simples', 1, 'pura'),
    ('T', 'T', 't', 'consoante_simples', 1, 'pura'),
    ('U', 'U', 'u', 'vogal', 1, 'pura'),
    ('V', 'V', 'v', 'consoante_simples', 2, 'pura'),
    ('W', 'W', 'w', 'consoante_complexa', 3, 'pura'),
    ('X', 'X', 'x', 'consoante_complexa', 3, 'pura'),
    ('Y', 'Y', 'y', 'consoante_complexa', 3, 'pura'),
    ('Z', 'Z', 'z', 'consoante_simples', 2, 'pura')
ON DUPLICATE KEY UPDATE letter = VALUES(letter);
