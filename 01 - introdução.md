# DOCUMENTO 01 — VISÃO GLOBAL DO SISTEMA
# Plataforma Educacional Infantil Gamificada

---

# 1. VISÃO GERAL DO PROJETO

## Objetivo

Desenvolver uma plataforma educacional gamificada voltada ao público infantil, com foco em:

- alfabetização;
- coordenação motora;
- criatividade;
- raciocínio lógico;
- memória;
- curiosidade;
- aprendizado progressivo;
- desenvolvimento cognitivo.

A plataforma será inicialmente desenvolvida como um sistema web responsivo e posteriormente migrada para aplicativos mobile utilizando Flutter.

---

# 2. OBJETIVOS PRINCIPAIS

## Objetivos pedagógicos

O sistema deverá:

- estimular o aprendizado infantil através de jogos;
- incentivar o desenvolvimento cognitivo;
- adaptar desafios conforme a idade;
- fornecer relatórios aos responsáveis;
- utilizar gamificação para retenção e engajamento.

---

## Objetivos técnicos

O sistema deverá:

- possuir arquitetura escalável;
- permitir adição rápida de novos jogos;
- possuir API centralizada;
- permitir integração futura com aplicativos Flutter;
- possuir separação clara entre backend, frontend e engine dos jogos.

---

# 3. ESTRUTURA GERAL DO SISTEMA

O sistema será dividido em:

```txt
Sistema Principal
├── Backend/API
├── Painel Administrativo
├── Plataforma do Usuário
├── Engine de Jogos
├── Sistema de Assinaturas
├── Sistema de Gamificação
├── Sistema de Relatórios
└── Aplicativos Mobile (futuro)



4. MÓDULOS DO SISTEMA
4.1 Módulo Administrativo

Responsável pelo gerenciamento total da plataforma.

Funcionalidades
Gestão de usuários
responsáveis;
crianças;
administradores;
professores;
escolas.
Gestão pedagógica
categorias por idade;
níveis de dificuldade;
organização dos jogos;
acompanhamento de progresso.
Gestão dos jogos
cadastro de jogos;
publicação/despublicação;
upload de assets;
controle de fases;
gerenciamento de desafios.
Gestão financeira
planos;
assinaturas;
pagamentos;
cupons;
relatórios financeiros.
Gestão analítica
métricas de uso;
retenção;
evolução das crianças;
desempenho dos jogos.
4.2 Plataforma do Usuário

Interface utilizada pelas crianças e responsáveis.

Funcionalidades
Criança
acesso aos jogos;
avatar;
recompensas;
evolução;
conquistas;
fases.
Responsáveis
relatórios;
controle parental;
tempo de uso;
progresso educacional;
gerenciamento da assinatura.
4.3 Engine de Jogos

Camada responsável pela execução padronizada dos jogos.

Objetivos
reutilização de código;
padronização visual;
gerenciamento centralizado;
facilidade de expansão.
5. TECNOLOGIAS DEFINIDAS
5.1 Backend
Linguagem
PHP 8.3+
Estrutura
arquitetura MVC modular;
API RESTful;
autenticação JWT.
Servidor
Apache ou Nginx.
5.2 Banco de Dados
Banco principal
MariaDB 10.6+
Objetivos
alta compatibilidade;
desempenho;
escalabilidade;
fácil manutenção.
5.3 Frontend Web
Tecnologias
HTML5;
CSS3;
Javascript ES6+.
Frameworks/Bibliotecas
Phaser.js (jogos);
Bootstrap ou TailwindCSS;
Axios;
SweetAlert;
Chart.js.
5.4 Aplicativos Mobile (Futuro)
Framework
Flutter
Plataformas
Android;
iOS.
Comunicação
consumo da API REST do backend.
5.5 Infraestrutura
Hospedagem
VPS Linux Ubuntu.
Serviços recomendados
Cloudflare;
Redis;
CDN;
armazenamento externo para assets.
6. ARQUITETURA DO SISTEMA
Estrutura geral
Frontend Web/App
        ↓
      API REST
        ↓
Backend PHP
        ↓
MariaDB
7. PADRÃO DE API

A API deverá ser RESTful.

Estrutura base
/api/v1/
Principais endpoints
/auth
/users
/children
/games
/categories
/progress
/rewards
/subscriptions
/payments
/reports
8. SISTEMA DE AUTENTICAÇÃO
Método

JWT (JSON Web Token)

Recursos
login;
refresh token;
permissões;
múltiplos níveis de acesso.
9. PADRONIZAÇÃO DOS JOGOS

Todos os jogos deverão seguir:

sistema de pontuação;
sistema de recompensa;
controle de tempo;
níveis de dificuldade;
feedback sonoro;
responsividade;
compatibilidade mobile.
10. CATEGORIZAÇÃO DOS JOGOS
Faixas etárias
Idade	Categoria
2–4	Coordenação
4–6	Alfabetização
6–8	Lógica inicial
8–10	Matemática
10+	Desafios cognitivos
11. TIPOS DE JOGOS PREVISTOS
Alfabetização
letras;
sílabas;
palavras;
leitura.
Coordenação
arrastar;
encaixar;
desenho.
Lógica
sequência;
memória;
padrões.
Criatividade
pintura;
criação;
histórias.
Matemática
soma;
contagem;
raciocínio.
12. SISTEMA DE GAMIFICAÇÃO
Recursos previstos
moedas;
estrelas;
medalhas;
rankings;
conquistas;
missões diárias;
níveis;
recompensas.
13. SISTEMA DE ASSINATURAS
Planos previstos
Gratuito
acesso limitado.
Premium
acesso completo.
Família
múltiplas crianças.
Escolar
múltiplos alunos.
14. SISTEMA DE CONTROLE PARENTAL
Recursos
limite de tempo;
relatórios;
desempenho;
progresso;
áreas de dificuldade;
recomendações.
15. ESTRUTURA DE PASTAS SUGERIDA
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
└── /public
16. PADRÕES DE DESENVOLVIMENTO
Backend
PSR-4;
Composer;
namespaces;
services;
repositories.
Frontend
componentes reutilizáveis;
Javascript modular;
carregamento assíncrono.
17. ESTRATÉGIA DE ESCALABILIDADE

O sistema deverá permitir:

expansão rápida;
novos jogos;
novos módulos;
internacionalização;
integração com IA;
integração escolar.
18. ROADMAP DO PROJETO
FASE 1
estrutura backend;
autenticação;
painel admin;
3 jogos iniciais;
sistema de usuários.
FASE 2
gamificação;
assinaturas;
relatórios;
métricas.
FASE 3
aplicativo Flutter;
notificações;
modo offline.
FASE 4
IA adaptativa;
relatórios inteligentes;
recomendações pedagógicas.
19. OBJETIVO FINAL DA PLATAFORMA

Criar uma plataforma educacional moderna, gamificada e escalável, capaz de:

auxiliar no desenvolvimento infantil;
gerar recorrência financeira;
atender famílias e escolas;
oferecer experiência divertida e pedagógica;
expandir para aplicativos mobile e mercado internacional.