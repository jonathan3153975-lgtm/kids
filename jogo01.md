# DOCUMENTO 04 — DESENVOLVIMENTO COMPLETO DO PRIMEIRO JOGO
# JOGO: CAÇA LETRAS
# Plataforma Educacional Infantil Gamificada

---

# 1. VISÃO GERAL DO JOGO

# Nome do jogo
Caça Letras

---

# Objetivo pedagógico

O jogo tem como objetivo:

- ensinar reconhecimento de letras;
- estimular alfabetização inicial;
- desenvolver coordenação motora;
- estimular associação visual e sonora;
- aumentar atenção e memória visual.

---

# Público-alvo

| Idade | Nível |
|---|---|
| 3–6 anos | Alfabetização inicial |

---

# Plataforma

- Web responsivo
- Desktop
- Tablet
- Smartphone

---

# Tecnologia

| Item | Tecnologia |
|---|---|
| Engine | Phaser.js |
| Renderização | HTML5 Canvas |
| Linguagem | Javascript ES6 |
| Áudio | WebAudio API |

---

# 2. CONCEITO DO JOGO

# Funcionamento

O jogo exibirá:

- letras espalhadas na tela;
- uma letra alvo;
- áudio pronunciando a letra;
- animações;
- pontuação;
- recompensas.

A criança deverá:
- tocar na letra correta;
- receber feedback positivo;
- avançar de fase.

---

# Fluxo básico

```txt id="x7z0n2"
Início
↓
Tela de instrução
↓
Letra sorteada
↓
Áudio reproduzido
↓
Criança escolhe letra
↓
Acertou?
├── Sim → Recompensa
└── Não → Feedback educativo
↓
Nova rodada


3. OBJETIVOS PEDAGÓGICOS DETALHADOS
Habilidades trabalhadas
Cognitivas
reconhecimento visual;
associação;
memória;
atenção.
Motoras
toque;
precisão;
coordenação.
Linguísticas
identificação de letras;
sons;
associação fonética.
4. ESTRUTURA DE TELAS
Telas do jogo
1. Splash Screen
2. Tela Inicial
3. Tutorial
4. Seleção de Fase
5. Gameplay
6. Tela de Vitória
7. Tela de Recompensa
8. Tela de Game Over
5. DIREÇÃO VISUAL
Objetivo visual

O jogo deve transmitir:

alegria;
segurança;
diversão;
simplicidade;
estímulo visual infantil.
Estilo artístico
Recomendado
cartoon 2D;
flat design;
elementos grandes;
bordas arredondadas.
Evitar
excesso de informação;
cores escuras;
textos pequenos;
elementos agressivos.
6. PALETA DE CORES
Cores principais
Elemento	Cor
Fundo	#87CEEB
Botões	#FFD93D
Texto principal	#333333
Feedback positivo	#4CAF50
Feedback negativo	#FF5252
Cartas/letras	#FFFFFF
Bordas	#FFB74D
Regras visuais
Letras
grandes;
bem legíveis;
contraste alto.
Fundo
suave;
com nuvens;
cenário infantil.
7. FONTES
Recomendadas
Fonte	Uso
Fredoka	Principal
Baloo 2	Infantil
Nunito	Informações
Configuração recomendada
Letras do jogo
tamanho mínimo: 80px;
peso: bold.
8. SISTEMA DE ÁUDIO
Objetivos

O áudio é extremamente importante para alfabetização.

Sons necessários
Feedback positivo
estrelas;
aplauso suave;
som alegre.
Feedback negativo
som leve;
nunca agressivo.
Narração

Todas as letras devem possuir:

pronúncia clara;
voz infantil suave;
ritmo lento.
Formato de áudio
Tipo	Formato
Efeitos	.mp3
Vozes	.mp3
Música	.ogg
Música de fundo
Características
baixa intensidade;
relaxante;
alegre;
repetição suave.
Volume recomendado
Elemento	Volume
Música	20%
Voz	100%
Efeitos	60%
9. SISTEMA DE ANIMAÇÃO
Objetivos

As animações devem:

manter atenção;
reforçar acertos;
tornar experiência divertida.
Animações obrigatórias
Acerto
brilho;
explosão de estrelas;
bounce;
partículas.
Erro
shake suave;
brilho vermelho leve.
Transições
fade;
scale;
bounce.
Tempo recomendado
Animação	Tempo
Bounce	300ms
Shake	250ms
Fade	400ms
10. ESTRUTURA DO PROJETO
Estrutura de pastas
/games/alphabet-hunt
├── /assets
│   ├── /images
│   ├── /audio
│   ├── /fonts
│   └── /sprites
│
├── /scenes
│   ├── BootScene.js
│   ├── MenuScene.js
│   ├── GameScene.js
│   ├── RewardScene.js
│   └── GameOverScene.js
│
├── /components
├── /helpers
├── game.js
├── config.js
└── index.html
11. CONFIGURAÇÃO DO PHASER
Instalação
CDN
<script src="https://cdn.jsdelivr.net/npm/phaser@3/dist/phaser.js"></script>
Configuração base
const config = {
    type: Phaser.AUTO,
    width: 1280,
    height: 720,
    backgroundColor: '#87CEEB',

    scale: {
        mode: Phaser.Scale.FIT,
        autoCenter: Phaser.Scale.CENTER_BOTH
    },

    physics: {
        default: 'arcade'
    },

    scene: [
        BootScene,
        MenuScene,
        GameScene,
        RewardScene
    ]
};

const game = new Phaser.Game(config);
12. SISTEMA DE GAMEPLAY
Funcionamento da rodada
Passo 1

Selecionar letra aleatória.

Passo 2

Reproduzir áudio.

Passo 3

Exibir letras na tela.

Passo 4

Aguardar interação.

Passo 5

Validar resposta.

Passo 6

Aplicar recompensa.

13. MECÂNICA DAS LETRAS
Quantidade inicial
Fase	Letras
1	3
2	4
3	5
4	6
Dificuldade progressiva
Inicial

Somente vogais.

Intermediário

Consoantes simples.

Avançado

Mistura completa.

14. SISTEMA DE PONTUAÇÃO
Regras
Ação	Pontos
Acerto	+10
Combo	+5
Erro	-2
Sistema de estrelas
Pontuação	Estrelas
90%+	3
70%+	2
50%+	1
15. SISTEMA DE RECOMPENSAS
Recompensas possíveis
moedas;
estrelas;
adesivos;
medalhas;
personagens.
Reforço positivo

Toda recompensa deve:

piscar;
emitir som;
animar.
16. SISTEMA DE DIFICULDADE
Variáveis
quantidade de letras;
velocidade;
tamanho;
distrações;
tempo.
Progressão
Fácil → Médio → Difícil
17. RESPONSIVIDADE
Objetivo

O jogo deve funcionar perfeitamente em:

desktop;
tablets;
celulares.
Regras
Mobile
botões grandes;
espaçamento amplo;
sem elementos pequenos.
Orientações
Elemento	Tamanho mínimo
Botões	80px
Letras	100px
Área de toque	120px
18. PERFORMANCE
Objetivos
carregamento rápido;
baixo consumo;
fluidez.
Regras
Imagens
utilizar WebP.
Áudios
compressão moderada.
Sprites
utilizar atlas.
FPS recomendado
60 FPS
19. SISTEMA DE ACESSIBILIDADE
Recursos importantes
áudio em todas as ações;
contraste elevado;
textos grandes;
poucos elementos simultâneos.
Futuro

Adicionar:

libras;
leitura automática;
modo daltônico.
20. SISTEMA DE DADOS
Dados enviados ao backend
{
  "child_id": 1,
  "game_id": 1,
  "score": 120,
  "hits": 10,
  "errors": 2,
  "time": 95,
  "completed": true
}
Endpoint sugerido
POST /api/v1/progress
21. SISTEMA DE FEEDBACK
Acerto
Deve acontecer:
brilho;
animação;
som;
voz positiva.
Erro
Deve acontecer:
explicação;
repetição da letra;
incentivo positivo.
Nunca utilizar
punição agressiva;
sons negativos fortes;
mensagens frustrantes.
22. SISTEMA DE TUTORIAL
Objetivo

Ensinar sem texto excessivo.

Estratégia
animações;
mãos apontando;
voz guiando;
poucos passos.
23. FLUXO PEDAGÓGICO
Objetivo

Evitar repetição cansativa.

Estratégia
alternar letras;
reforçar erros frequentes;
repetir aprendizado.
24. SISTEMA DE MÉTRICAS
Registrar
tempo médio;
erros por letra;
taxa de acerto;
retenção;
abandono.
25. OBJETIVOS DO MVP

O primeiro jogo deve validar:

aceitação infantil;
usabilidade;
retenção;
dificuldade;
arquitetura da engine;
integração backend.
26. CHECKLIST FINAL
Backend
API funcional;
autenticação;
progresso salvo.
Frontend
responsivo;
animações;
sons.
Gameplay
pontuação;
progressão;
tutorial;
feedback.
Assets
imagens;
fontes;
sons;
músicas.
27. OBJETIVO FINAL DO JOGO

Criar um jogo:

divertido;
educativo;
leve;
intuitivo;
altamente reutilizável;
capaz de servir como base para todos os futuros jogos da plataforma.