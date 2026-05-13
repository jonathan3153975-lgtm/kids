# 📋 DOCUMENTO — ALTERAÇÕES NO BANCO DE DADOS PARA JOGOS

## Objetivo
Documentar todas as alterações, novas tabelas e campos necessários para suportar o sistema de jogos completo, iniciando com o "Caça Letras".

---

## 1. NOVAS TABELAS

### 1.1 - `alphabet_items` (Letras do Alfabeto)
**Propósito:** Armazenar dados de cada letra com pronúncia, imagens e variações.

**Campos:**
- `id` - Chave primária
- `letter` - Letra (A-Z)
- `uppercase` - Forma maiúscula
- `lowercase` - Forma minúscula
- `audio_url` - URL do MP3 de pronúncia
- `image_url` - Imagem/ícone da letra
- `category` - Categoria (vogal, consoante_simples, consoante_complexa)
- `difficulty_level` - Nível de dificuldade (1-5)
- `sound_variant` - Variações de som (pura, silaba, palavra)

**Razão:** Estruturar dados de alfabeto para reutilização em diferentes fases e jogos.

---

### 1.2 - `game_sessions` (Sessões de Jogo)
**Propósito:** Rastrear cada sessão individual de jogo com métricas em tempo real.

**Campos:**
- `id` - Chave primária
- `child_id` - Referência à criança
- `game_id` - Referência ao jogo
- `phase_id` - Fase específica do jogo
- `started_at` - Data/hora de início
- `ended_at` - Data/hora de término
- `duration_seconds` - Duração total em segundos
- `score` - Pontuação final
- `hits_count` - Total de acertos
- `errors_count` - Total de erros
- `stars_earned` - Estrelas conquistadas (0-3)
- `coins_earned` - Moedas conquistadas
- `status` - Status (playing, completed, abandoned)
- `device` - Dispositivo usado (mobile, tablet, desktop)
- `browser_info` - Info do navegador
- `completion_percentage` - Percentual de conclusão
- `data_payload` - JSON com dados específicos do jogo

**Razão:** Criar histórico granular de cada partida jogada.

---

### 1.3 - `game_events` (Eventos do Jogo)
**Propósito:** Registrar eventos detalhados durante a sessão (acertos, erros, cliques, etc.).

**Campos:**
- `id` - Chave primária
- `session_id` - Referência à sessão
- `event_type` - Tipo de evento (guess, error, skip, hint, timeout)
- `target_letter` - Letra alvo (para Caça Letras)
- `selected_letter` - Letra selecionada pela criança
- `is_correct` - Booleano indicando acerto
- `time_elapsed` - Tempo decorrido até o evento
- `reaction_time` - Tempo de reação em ms
- `feedback_given` - Tipo de feedback exibido
- `created_at` - Data/hora do evento

**Razão:** Permitir análise detalhada de padrões de erro e aprendizado.

---

### 1.4 - `game_audio_library` (Biblioteca de Áudio)
**Propósito:** Gerenciar centralizadamente todos os áudios do jogo.

**Campos:**
- `id` - Chave primária
- `game_id` - Jogo relacionado
- `audio_type` - Tipo (letter_pronunciation, feedback, music, narration)
- `name` - Nome descritivo
- `file_path` - Caminho do arquivo
- `language` - Idioma (pt-BR, en-US, etc.)
- `voice_actor` - Ator de voz
- `duration_ms` - Duração em ms
- `created_at` - Data de upload

**Razão:** Centralizar gestão de áudios para reutilização e atualizações.

---

## 2. MODIFICAÇÕES EM TABELAS EXISTENTES

### 2.1 - Tabela `games`
**Novos Campos:**
- `audio_enabled` (BOOLEAN) - Se o jogo usa áudio
- `has_tutorial` (BOOLEAN) - Se possui tutorial
- `estimated_duration_minutes` (INT) - Duração estimada
- `target_skills` (JSON) - Habilidades alvo (ex: ["letra_A", "pronúncia"])
- `accessibility_features` (JSON) - Recursos de acessibilidade

**Razão:** Metadados para melhor configuração de jogos.

---

### 2.2 - Tabela `game_phases`
**Novos Campos:**
- `available_letters` (JSON) - Array de letras disponíveis
- `target_letters` (JSON) - Array de letras alvo/resposta
- `time_limit_seconds` (INT) - Limite de tempo por fase
- `max_errors_allowed` (INT) - Máximo de erros permitidos
- `passing_score` (INT) - Pontuação mínima para passar
- `difficulty_multiplier` (FLOAT) - Multiplicador de dificuldade (1.0-3.0)

**Razão:** Permitir customização granular de cada fase.

---

### 2.3 - Tabela `child_progress`
**Novos Campos:**
- `last_played_at` (TIMESTAMP) - Última vez que jogou
- `total_sessions` (INT) - Total de sessões
- `best_score` (INT) - Melhor pontuação
- `average_score` (DECIMAL) - Pontuação média
- `success_rate` (DECIMAL) - Taxa de sucesso (%)
- `favorite` (BOOLEAN) - Marcado como favorito
- `streak_count` (INT) - Contagem de vitórias consecutivas
- `recommendations` (JSON) - Recomendações do sistema

**Razão:** Rastrear performance detalhada e gerar recomendações personalizadas.

---

### 2.4 - Tabela `game_levels`
**Novos Campos:**
- `letter_set` (JSON) - Conjunto específico de letras para este nível
- `time_multiplier` (FLOAT) - Multiplicador de tempo

**Razão:** Configuração mais específica por nível.

---

## 3. MODIFICAÇÕES EM TABELAS DE DADOS

### 3.1 - Adicionar dados em `alphabet_items`
Inserir todas as 26 letras (A-Z) com:
- Categorias (vogal, consoante)
- Níveis de dificuldade
- Referências a áudios

### 3.2 - Adicionar dados em `game_audio_library`
Registrar todos os áudios necessários para Caça Letras:
- Pronúncia de cada letra
- Sons de feedback (acerto, erro)
- Música de fundo
- Narração de instruções

---

## 4. ÍNDICES ADICIONAIS

```sql
CREATE INDEX idx_game_sessions_child ON game_sessions(child_id);
CREATE INDEX idx_game_sessions_game ON game_sessions(game_id);
CREATE INDEX idx_game_events_session ON game_events(session_id);
CREATE INDEX idx_alphabet_items_category ON alphabet_items(category);
CREATE INDEX idx_game_audio_game ON game_audio_library(game_id);
```

---

## 5. MIGRAÇÕES POR FASE

### Fase 1 (MVP - Caça Letras)
✅ Criar `alphabet_items`
✅ Criar `game_sessions`
✅ Criar `game_events`
✅ Modificar `games`, `game_phases`, `child_progress`

### Fase 2 (Próximos Jogos)
⏳ Criar `game_audio_library`
⏳ Expandir configurações de `game_levels`

### Fase 3 (Analytics Avançado)
⏳ Criar tabelas de análise preditiva
⏳ Integrar recomendações de IA

---

## 6. NOTAS IMPORTANTES

- Todas as novas tabelas possuem foreign keys com `ON DELETE CASCADE`
- JSON é usado para dados flexíveis e sem schema rígido
- Índices foram estrategicamente colocados em colunas de filtro frequente
- Timestamps padrão para auditoria

---

## 7. PRÓXIMA AÇÃO

Implementar migrações em ordem de dependência:
1. `alphabet_items` (sem dependências)
2. `game_sessions` (depende de `child_id`, `game_id`)
3. `game_events` (depende de `game_sessions`)
4. Modificações em tabelas existentes
