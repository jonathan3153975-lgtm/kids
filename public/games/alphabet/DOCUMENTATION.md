# 🎮 DOCUMENTAÇÃO TÉCNICA - CAÇA LETRAS

## Informações Gerais
- **Nome:** Caça Letras
- **Tipo:** Jogo Educativo Infantil
- **Engine:** Phaser.js 3.60
- **Público-alvo:** 4-7 anos
- **Plataformas:** Web (Desktop, Tablet, Mobile)
- **Status:** MVP Completo

---

## 📁 Estrutura de Arquivos

```
/public/games/alphabet/
├── index.html          # Página HTML principal
├── game-full.js        # Lógica completa do jogo (todas as cenas)
├── game.js             # Versão anterior (deprecada)
└── README.md           # Este arquivo
```

---

## 🎯 Funcionalidades Implementadas

### ✅ Cenas Criadas

1. **BootScene**
   - Carregamento de assets
   - Inicialização de dados da sessão
   - Barra de progresso simples

2. **MenuScene**
   - Tela inicial com instruções
   - Botão "Jogar Agora"
   - Decoração visual com nuvens
   - Animações de hover

3. **GameScene** (Principal)
   - Gameplay de reconhecimento de letras
   - Mecânica de clique/toque em letras
   - Sistema de pontuação em tempo real
   - Timer de 60 segundos
   - Feedback visual (acertos e erros)
   - Geração dinâmica de posições para letras
   - Detecção de reação time

4. **RewardScene**
   - Exibição de estrelas (0-3)
   - Estatísticas da partida
   - Botões "Jogar Novamente" e "Voltar"
   - Animações de celebração

5. **GameOverScene**
   - Estrutura base para expansão futura

---

## 🎮 Mecânica do Jogo

### Fluxo Básico
1. Menu inicial com instruções
2. Começar partida com letra aleatória sorteada
3. Som da letra é "reproduzido" (simulado)
4. 8 botões com letras aparecem na tela
5. Criança toca na letra correta
6. Feedback visual e pontuação atualizada
7. Nova letra sorteada automaticamente
8. Após 60 segundos, exibir resultados

### Sistema de Pontuação
- **Acerto:** 5-10 pontos (baseado em tempo de reação)
- **Erro:** -2 pontos (em versão futura)
- **Combo:** Bônus por acertos consecutivos (futuro)

### Sistema de Estrelas
- **3 Estrelas:** 90%+ de taxa de acerto
- **2 Estrelas:** 70-89% de taxa de acerto
- **1 Estrela:** 50-69% de taxa de acerto

---

## 🛠️ Configuração Técnica

### Phaser Config
```javascript
- Tipo: AUTO (webgl/canvas)
- Resolução: 1280x720
- Scale Mode: FIT (responsivo)
- Physics: Arcade (básico, sem gravidade)
- Render: Pixel art + antialias
```

### Paleta de Cores
| Elemento | Cor | Uso |
|---|---|---|
| Fundo | #87CEEB | Céu azul |
| Botões Corretos | #4ade80 | Verde sucesso |
| Botões Outros | #FFFFFF | Branco |
| Bordas | #FFB74D | Laranja |
| Texto Alvo | #FF6F6F | Vermelho destaque |
| Texto Principal | #333333 | Cinza escuro |

### Fontes
- **Fredoka:** Títulos e letras do jogo (80px)
- **Baloo 2:** Botões e UI (24-36px)
- **Nunito:** Informações e instruções (20-28px)

---

## 📊 Dados Rastreados

Por sessão de jogo:
- `score` - Pontuação total
- `hits` - Número de acertos
- `errors` - Número de erros
- `stars` - Estrelas conquistadas (0-3)
- `currentPhase` - Fase atual
- `timeLeft` - Tempo restante
- `reactionTimes` - Array de tempos de reação

---

## 🔊 Integração de Áudio

**Status:** Simulado (pronto para integração real)

### Áudios Necessários
```javascript
// Pronúncia de letras (a ser implementado)
/assets/audio/letter_a.mp3
/assets/audio/letter_b.mp3
... (para cada letra)

// Feedback
/assets/audio/success.mp3     // Acerto
/assets/audio/error.mp3       // Erro
/assets/audio/background.ogg  // Música fundo
```

**Volumes Recomendados:**
- Pronúncia: 100%
- Feedback: 60%
- Música: 20%

---

## 📱 Responsividade

### Breakpoints
- **Desktop:** 1280x720 (padrão)
- **Tablet:** 1024x768 (scale automático)
- **Mobile:** 480x800+ (scale automático)

### Ajustes por Dispositivo
- Botões mínimo 80px (toque confortável)
- Letras mínimo 100px
- Área de toque mínimo 120px
- Espaçamento amplo entre elementos

---

## 🚀 Próximas Implementações

### Fase 1 (Curto Prazo)
- [ ] Integrar áudios reais
- [ ] Conectar API para salvar progresso
- [ ] Sistema de níveis/fases
- [ ] Progressão de dificuldade

### Fase 2 (Médio Prazo)
- [ ] Sistema de moedas/recompensas
- [ ] Achievements
- [ ] Modo com tempo limite
- [ ] Modo com limite de erros

### Fase 3 (Longo Prazo)
- [ ] Multiplayer local
- [ ] Temas visuais customizáveis
- [ ] Suporte a acessibilidade (LIBRAS, etc)
- [ ] Analytics detalhado

---

## 🐛 Conhecidos Problemas / Limitações

1. **Áudio Simulado:** Sons não reproduzem (estrutura pronta)
2. **Sem Persistência:** Dados não salvos automaticamente
3. **Sem Validação Backend:** Dados não verificados no servidor
4. **Sem Limite de Erros:** Erros não limitam o jogo
5. **UI Fixa:** Não responde dinamicamente a janela redimensionada

---

## 📝 Como Expandir

### Adicionar Nova Cena
```javascript
class NovaScene extends Phaser.Scene {
    constructor() {
        super({ key: 'NovaScene' });
    }

    create() {
        // Adicionar à config: scene: [..., NovaScene]
    }
}
```

### Modificar Mecânica
- Editar `GameScene.handleLetterClick()` para nova lógica
- Alterar `generateRandomPositions()` para diferentes layouts
- Modificar `createLetterButtons()` para novas variações

### Integrar API
```javascript
// Em GameScene.endGame():
fetch('/api/v1/game-session', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        child_id: childId,
        game_id: 1,
        score: score,
        hits: hits,
        errors: errors,
        stars: stars,
        time: 60 - this.timeLeft
    })
});
```

---

## 🔧 Debugging

### Ativar Debug do Phaser
```javascript
// Em config: render: { pixelArt: true, antialias: true }
// Mudar para: debug: true, debugShowBody: true
```

### Console Log Úteis
```javascript
console.log('Letra alvo:', this.currentLetter);
console.log('Reação time:', reactionTime + 'ms');
console.log('Taxa de acerto:', (hits / (hits + errors)) * 100 + '%');
```

---

## 📞 Suporte e Manutenção

**Desenvolvedor:** IA Assistant  
**Última atualização:** 12/05/2026  
**Versão:** 1.0.0-MVP  

Para modificações, consulte a seção "Como Expandir" acima.
