# Diário de Bordo — Kids Platform

---

## Entrada: 22/05/2026

### Situação Geral

Projeto em fase **MVP funcional**. A estrutura base está sólida, o primeiro jogo está completo e jogável, mas a integração com o banco de dados ainda não foi realizada — o sistema opera com dados hardcoded em `config/app.php`.

---

### Stack

| Camada | Tecnologia |
|---|---|
| Backend | PHP 8.3+, MVC customizado |
| Autenticação | Firebase JWT (access 1h / refresh 7 dias) |
| Banco de Dados | MariaDB, PDO, ORM leve customizado |
| Frontend | Bootstrap 5.3.3, JavaScript puro |
| Jogos | Phaser.js 3.60 |
| Dev Server | PHP built-in server / Python proxy (`server.py`) |

---

### Módulos — Estado Atual

#### Completo

- Estrutura MVC (Router, Controller, Model, View, Middleware)
- Autenticação JWT (login, logout, proteção de rotas)
- Interface com tema infantil (Bootstrap 5 customizado, fontes Baloo/Nunito/Fredoka)
- Páginas: home, login, dashboard, children, games, admin
- **Jogo "Caça Letras"** — 5 cenas Phaser (Boot → Menu → Game → Reward → GameOver), 26 letras A-Z, 60s de gameplay, sistema de 0–3 estrelas, responsivo
- Schema do banco — 8 tabelas, índices, foreign keys, 26 registros do alfabeto pré-inseridos
- API REST — 6 endpoints criados (`/api/v1/health`, `auth/login`, `children`, `games`)
- Documentação técnica — 8 documentos na pasta `Documentação/`

#### Parcial

- **API REST** — endpoints existem mas retornam dados mockados de sessão, sem leitura real do banco
- **Models** — conexão PDO funciona, classes criadas, mas sem uso efetivo nas rotas principais

#### Não Iniciado

| Funcionalidade | Situação |
|---|---|
| Autenticação via banco (`users` table) | Usa dados hardcoded em `config/app.php` |
| Registro de novos usuários | Não existe fluxo de criação de conta |
| Persistência de progresso (`child_progress`) | Tabela criada, lógica ausente |
| Sistema de recompensas (coins, stars) | Tabelas criadas, lógica ausente |
| Níveis e dificuldade progressiva | Tabelas criadas, jogo atual tem fase única |
| Áudio no jogo | Estrutura no BD pronta, nenhum MP3 integrado |
| Segundo jogo (Memória Infantil) | Listado na interface com tela "coming soon" |
| Testes automatizados | Apenas guia de testes manuais documentado |
| CI/CD | Não configurado |

---

### Gaps Críticos

1. **Autenticação hardcoded** — login funciona com 2 contas fixas (`parent@kids.local`, `admin@kids.local` / senha `123456`). Nenhuma conta real pode ser criada.
2. **API sem persistência** — todos os endpoints retornam dados de sessão/mock, não do MariaDB.
3. **Progresso não salvo** — scores do jogo Caça Letras não são persistidos por criança.
4. **Sem áudio** — o jogo não tem feedback sonoro em nenhuma interação.

---

### Próximos Passos (por prioridade)

1. Conectar autenticação ao banco (`users` table) e criar fluxo de registro
2. Ligar endpoints da API às queries reais do MariaDB
3. Salvar resultados de sessão na tabela `child_progress`
4. Integrar assets de áudio no Caça Letras
5. Implementar lógica de coins/estrelas pós-partida
6. Desenvolver o segundo jogo (Memória Infantil)

---

### Repositório

- Branch: `main`
- Commits: 2 (`b0649a2` inicial sistema, `e0ab48c` af)
- Working tree: limpo
- Remoto: sincronizado

---

<!-- Nova entrada abaixo desta linha -->
