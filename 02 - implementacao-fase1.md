# DOCUMENTO 02 — IMPLEMENTAÇÃO DA FASE 1
# Plataforma Educacional Infantil Gamificada

---

# 1. OBJETIVO DA FASE 1

A Fase 1 consiste na criação do MVP (Minimum Viable Product) da plataforma.

O objetivo desta fase é validar:

- arquitetura;
- fluxo dos usuários;
- funcionamento dos jogos;
- sistema de autenticação;
- estrutura administrativa;
- gamificação inicial;
- retenção básica;
- experiência do usuário.

---

# 2. OBJETIVOS PRINCIPAIS DA FASE 1

Ao final da Fase 1, o sistema deverá possuir:

- backend funcional;
- API REST;
- autenticação;
- painel administrativo;
- sistema de usuários;
- sistema de crianças;
- categorização dos jogos;
- 3 jogos iniciais;
- sistema de progresso;
- sistema básico de gamificação;
- sistema de assinaturas;
- versão web responsiva.

---

# 3. ESCOPO DA FASE 1

# Módulos que serão desenvolvidos

```txt
FASE 1
├── Backend/API
├── Sistema de autenticação
├── Painel administrativo
├── Cadastro de usuários
├── Cadastro de crianças
├── Sistema de jogos
├── Sistema de progresso
├── Sistema de assinaturas
├── Gamificação básica
└── Frontend web responsivo



4. TECNOLOGIAS DEFINIDAS
Backend
Item	Tecnologia
Linguagem	PHP 8.3+
Arquitetura	MVC
API	RESTful
Autenticação	JWT
ORM	PDO
Dependências	Composer
Frontend
Item	Tecnologia
Estrutura	HTML5
Estilo	CSS3
Linguagem	Javascript ES6+
Framework CSS	Bootstrap ou Tailwind
Requisições	Axios
Alertas	SweetAlert
Jogos
Item	Tecnologia
Engine	Phaser.js
Renderização	HTML5 Canvas
Áudio	WebAudio API
Banco de Dados
Item	Tecnologia
Banco	MariaDB
Versão	10.6+
Infraestrutura
Item	Tecnologia
Sistema operacional	Ubuntu Server
Web server	Apache ou Nginx
Cache	Redis (futuro)
5. ESTRUTURA DO PROJETO
Estrutura de pastas
/project
├── /api
├── /admin
├── /app
├── /games
├── /assets
├── /storage
├── /database
├── /config
├── /core
├── /modules
├── /vendor
├── /public
└── /logs
6. ESTRUTURA DO BACKEND
Objetivo

O backend será responsável por:

autenticação;
regras de negócio;
gerenciamento de usuários;
progresso dos jogos;
assinaturas;
API.
Estrutura interna
/api
├── /Controllers
├── /Models
├── /Services
├── /Repositories
├── /Middlewares
├── /Routes
├── /Helpers
└── /Validators
7. PADRÃO MVC
Controllers

Responsáveis por:

receber requisições;
validar entradas;
retornar respostas.
Services

Responsáveis pelas:

regras de negócio;
lógica central.
Repositories

Responsáveis por:

comunicação com banco;
queries.
Models

Representação das entidades.

8. CONFIGURAÇÃO INICIAL DO PROJETO
Passo 1 — Instalar PHP 8.3+

Verificar:

php -v
Passo 2 — Instalar Composer

Verificar:

composer -V
Passo 3 — Criar projeto
mkdir kid-platform
cd kid-platform
Passo 4 — Inicializar Composer
composer init
Passo 5 — Instalar dependências
JWT
composer require firebase/php-jwt
Dotenv
composer require vlucas/phpdotenv
9. CONFIGURAÇÃO DO AMBIENTE
Criar arquivo .env
APP_NAME=KidPlatform
APP_ENV=development

DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=kidsystem
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=secret_key
10. CONFIGURAÇÃO DO BANCO
Criar banco
CREATE DATABASE kidsystem CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
11. SISTEMA DE ROTAS
Estrutura
/api/v1/
Rotas iniciais
POST   /auth/login
POST   /auth/register

GET    /games
GET    /games/{id}

GET    /children
POST   /children

GET    /progress
POST   /progress

GET    /subscriptions
POST   /subscriptions
12. SISTEMA DE AUTENTICAÇÃO
Método

JWT (JSON Web Token)

Fluxo
Usuário → Login → Token JWT → API → Validação
Recursos necessários
login;
logout;
refresh token;
middleware de autenticação;
permissões.
13. NÍVEIS DE ACESSO
Perfis
Perfil	Permissões
admin	controle total
parent	responsável
child	criança
teacher	escola/professor
14. PAINEL ADMINISTRATIVO
Objetivo

Gerenciar toda a plataforma.

Funcionalidades da Fase 1
Dashboard
total de usuários;
total de crianças;
jogos mais acessados;
assinaturas.
Gestão de jogos
cadastrar jogos;
editar;
publicar;
categorizar.
Gestão de usuários
visualizar;
editar;
bloquear.
Gestão de assinaturas
visualizar pagamentos;
status;
planos.
15. SISTEMA DE JOGOS
Engine

Phaser.js

Estrutura dos jogos
/games
├── /alphabet
├── /memory
├── /drag-drop
└── /shared
Estrutura padrão de cada jogo
/game-name
├── index.html
├── game.js
├── styles.css
├── assets
└── config.js
16. JOGOS DA FASE 1
Jogo 1 — Caça Letras
Objetivo

Reconhecimento de letras.

Recursos
áudio;
pontuação;
animações.
Jogo 2 — Memória Infantil
Objetivo

Memória visual.

Recursos
fases;
níveis;
dificuldade crescente.
Jogo 3 — Arraste e Solte
Objetivo

Coordenação motora.

Recursos
drag and drop;
feedback visual;
recompensa.
17. SISTEMA DE GAMIFICAÇÃO
Recursos da Fase 1
estrelas;
pontuação;
níveis;
recompensas simples.
Fluxo
Jogo → Pontuação → Recompensa → Evolução
18. SISTEMA DE PROGRESSO
Objetivo

Salvar:

fases concluídas;
pontuação;
tempo jogado;
evolução.
Informações registradas
Informação	Tipo
pontuação	inteiro
tempo	inteiro
erros	inteiro
acertos	inteiro
fase	inteiro
19. FRONTEND WEB
Objetivos
responsividade;
experiência infantil;
carregamento rápido;
compatibilidade mobile.
Estrutura
/app
├── /pages
├── /components
├── /layouts
├── /assets
└── /services
20. TELAS NECESSÁRIAS
Públicas
home;
login;
cadastro;
planos.
Usuário
dashboard;
jogos;
progresso;
perfil;
recompensas.
Admin
dashboard;
usuários;
jogos;
assinaturas;
relatórios.
21. SISTEMA DE ASSINATURAS
Plataforma inicial

Mercado Pago.

Recursos
assinatura mensal;
webhook;
status;
renovação.
Planos iniciais
Plano	Recursos
gratuito	limitado
premium	acesso completo
22. RESPONSIVIDADE

O sistema deverá funcionar em:

desktop;
tablet;
smartphone.
23. SEGURANÇA
Recursos obrigatórios
JWT;
hash bcrypt;
validação de entrada;
proteção SQL Injection;
proteção XSS;
rate limit futuro.
24. PADRÕES VISUAIS
Objetivos
interface infantil;
cores vibrantes;
ícones grandes;
animações suaves;
navegação simples.
25. SISTEMA DE ÁUDIO

Todos os jogos deverão possuir:

feedback sonoro;
música opcional;
efeitos educativos.
26. SISTEMA DE LOGS

Registrar:

erros;
login;
pagamentos;
atividades críticas.
27. ROADMAP DA IMPLEMENTAÇÃO
ETAPA 1

Estrutura do backend.

ETAPA 2

Sistema de autenticação.

ETAPA 3

Painel administrativo.

ETAPA 4

Sistema de usuários.

ETAPA 5

Engine de jogos.

ETAPA 6

Desenvolvimento dos 3 jogos.

ETAPA 7

Gamificação.

ETAPA 8

Sistema de assinaturas.

ETAPA 9

Frontend responsivo.

ETAPA 10

Testes gerais.

28. CRITÉRIOS DE CONCLUSÃO DA FASE 1

A Fase 1 será considerada concluída quando:

usuários conseguirem se cadastrar;
responsáveis conseguirem adicionar crianças;
jogos estiverem funcionais;
progresso estiver sendo salvo;
painel administrativo estiver operacional;
assinaturas estiverem integradas;
sistema estiver responsivo;
MVP estiver pronto para testes reais.
29. OBJETIVO FINAL DA FASE 1

Entregar um MVP funcional capaz de:

validar o modelo de negócio;
validar retenção;
validar arquitetura;
iniciar aquisição de usuários;
preparar a plataforma para expansão futura.