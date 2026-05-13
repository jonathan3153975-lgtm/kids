/**
 * CAÇA LETRAS - Jogo Educativo Infantil
 * Desenvolvido com Phaser.js 3.60
 * Objetivo: Reconhecimento de letras e alfabetização
 * Público-alvo: 4-7 anos
 */

// Configuração do Phaser
const config = {
    type: Phaser.AUTO,
    width: 1280,
    height: 720,
    backgroundColor: '#87CEEB',
    scale: {
        mode: Phaser.Scale.FIT,
        autoCenter: Phaser.Scale.CENTER_BOTH,
        fullscreenTarget: 'parent',
        expandParent: true
    },
    physics: {
        default: 'arcade',
        arcade: {
            debug: false,
            gravity: { y: 0 }
        }
    },
    scene: [BootScene, MenuScene, GameScene, RewardScene, GameOverScene],
    render: {
        pixelArt: true,
        antialias: true
    }
};

const game = new Phaser.Game(config);

/**
 * CENA 1: BOOT SCENE
 * Carregamento de assets e inicialização
 */
class BootScene extends Phaser.Scene {
    constructor() {
        super({ key: 'BootScene' });
    }

    preload() {
        // Criar barra de carregamento simples
        const progressBar = this.add.rectangle(640, 360, 400, 30, 0xffd93d);
        const progressBox = this.add.rectangle(640, 360, 400, 30);
        progressBox.setStrokeStyle(3, 0x333333);

        this.load.on('progress', (value) => {
            progressBar.width = 400 * value;
        });

        // Aqui carregaríamos assets reais
        // this.load.audio('click', 'assets/audio/click.mp3');
        // this.load.image('background', 'assets/images/bg.png');
    }

    create() {
        // Inicializar dados da sessão
        this.registry.set('score', 0);
        this.registry.set('hits', 0);
        this.registry.set('errors', 0);
        this.registry.set('currentPhase', 1);
        this.registry.set('stars', 0);

        this.scene.start('MenuScene');
    }
}

/**
 * CENA 2: MENU SCENE
 * Tela inicial e instruções
 */
class MenuScene extends Phaser.Scene {
    constructor() {
        super({ key: 'MenuScene' });
    }

    create() {
        // Fundo gradiente
        const graphics = this.make.graphics({ x: 0, y: 0, add: false });
        graphics.fillStyle(0x87ceeb, 1);
        graphics.fillRect(0, 0, 1280, 720);
        graphics.generateTexture('background', 1280, 720);
        graphics.destroy();

        this.add.image(640, 360, 'background');

        // Desenhar nuvens decorativas
        this.drawClouds();

        // Título
        const titleText = this.add.text(640, 150, 'Caça Letras', {
            fontSize: '80px',
            fontFamily: 'Fredoka',
            fill: '#333333',
            fontStyle: 'bold',
            align: 'center'
        }).setOrigin(0.5);

        // Subtitle
        this.add.text(640, 250, 'Encontre as letras corretas!', {
            fontSize: '32px',
            fontFamily: 'Nunito',
            fill: '#666666',
            align: 'center'
        }).setOrigin(0.5);

        // Instruções
        const instructions = [
            '🎯 Encontre a letra que será mostrada',
            '🎧 Ouça o som da letra',
            '⭐ Ganhe estrelas por acertos',
            '🏆 Complete 60 segundos de desafio'
        ];

        let yPos = 330;
        instructions.forEach((text) => {
            this.add.text(640, yPos, text, {
                fontSize: '24px',
                fontFamily: 'Nunito',
                fill: '#333333',
                align: 'center'
            }).setOrigin(0.5);
            yPos += 45;
        });

        // Botão Jogar
        const playButton = this.add.rectangle(640, 600, 300, 80, 0x4CAF50);
        playButton.setInteractive({ useHandCursor: true });

        this.add.text(640, 600, 'JOGAR AGORA', {
            fontSize: '36px',
            fontFamily: 'Baloo 2',
            fill: '#FFFFFF',
            fontStyle: 'bold',
            align: 'center'
        }).setOrigin(0.5);

        // Animação hover
        playButton.on('pointerover', () => {
            playButton.setFillStyle(0x45a049);
            this.tweens.add({
                targets: playButton,
                scaleX: 1.1,
                scaleY: 1.1,
                duration: 200
            });
        });

        playButton.on('pointerout', () => {
            playButton.setFillStyle(0x4CAF50);
            this.tweens.add({
                targets: playButton,
                scaleX: 1.0,
                scaleY: 1.0,
                duration: 200
            });
        });

        playButton.on('pointerdown', () => {
            this.scene.start('GameScene');
        });
    }

    drawClouds() {
        // Desenho de nuvens com graphics
        const graphics = this.make.graphics({ x: 0, y: 0, add: false });
        graphics.fillStyle(0xffffff, 0.7);

        // Nuvem 1
        this.drawCloud(graphics, 150, 100, 50);
        // Nuvem 2
        this.drawCloud(graphics, 1100, 150, 60);
        // Nuvem 3
        this.drawCloud(graphics, 600, 80, 45);
    }

    drawCloud(graphics, x, y, size) {
        graphics.fillCircle(x, y, size);
        graphics.fillCircle(x + size * 1.5, y, size * 0.8);
        graphics.fillCircle(x - size * 1.5, y, size * 0.8);
    }
}

/**
 * CENA 3: GAME SCENE
 * Gameplay principal
 */
class GameScene extends Phaser.Scene {
    constructor() {
        super({ key: 'GameScene' });
        this.timeLeft = 60;
        this.currentLetter = '';
        this.letterObjects = [];
        this.gameActive = true;
        this.roundStartTime = 0;
        this.reactionTimes = [];
    }

    create() {
        // Fundo
        const graphics = this.make.graphics({ x: 0, y: 0, add: false });
        graphics.fillStyle(0x87ceeb, 1);
        graphics.fillRect(0, 0, 1280, 720);
        graphics.generateTexture('gameBackground', 1280, 720);
        graphics.destroy();

        this.add.image(640, 360, 'gameBackground');

        // UI
        this.createUI();

        // Iniciar jogo
        this.startNewRound();

        // Timer
        this.time.addEvent({
            delay: 1000,
            callback: this.updateTimer,
            callbackScope: this,
            loop: true
        });

        // Input
        this.input.on('pointerdown', this.onScreenClick, this);
    }

    createUI() {
        // Pontuação
        this.scoreText = this.add.text(100, 50, 'Pontos: 0', {
            fontSize: '32px',
            fontFamily: 'Baloo 2',
            fill: '#333333',
            fontStyle: 'bold'
        });

        // Tempo
        this.timeText = this.add.text(1180, 50, 'Tempo: 60s', {
            fontSize: '32px',
            fontFamily: 'Baloo 2',
            fill: '#333333',
            fontStyle: 'bold'
        }).setOrigin(1, 0);

        // Letra alvo
        this.targetText = this.add.text(640, 120, '', {
            fontSize: '80px',
            fontFamily: 'Fredoka',
            fill: '#FF6F6F',
            fontStyle: 'bold',
            backgroundColor: '#FFFFFF',
            padding: { x: 20, y: 10 },
            align: 'center'
        }).setOrigin(0.5);

        // Instruções
        this.instructionText = this.add.text(640, 220, 'Toque na letra mostrada acima!', {
            fontSize: '24px',
            fontFamily: 'Nunito',
            fill: '#333333',
            align: 'center'
        }).setOrigin(0.5);

        // Áudio ativo
        this.add.text(50, 120, '🔊 Áudio', {
            fontSize: '20px',
            fontFamily: 'Nunito',
            fill: '#666666'
        });
    }

    startNewRound() {
        // Limpar letras anteriores
        this.letterObjects.forEach(letter => letter.destroy());
        this.letterObjects = [];

        // Escolher letra aleatória
        const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        this.currentLetter = alphabet[Phaser.Math.Between(0, 25)];

        this.targetText.setText(this.currentLetter);
        this.instructionText.setText(`Toque em: ${this.currentLetter}`);

        // Reproduzir áudio (simulado)
        this.playLetterAudio(this.currentLetter);

        // Criar letras na tela
        this.createLetterButtons();

        this.roundStartTime = Date.now();
    }

    createLetterButtons() {
        const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numLetters = 8;
        const positions = this.generateRandomPositions(numLetters);

        // Garantir que pelo menos uma letra correta existe
        const correctIndex = Phaser.Math.Between(0, numLetters - 1);

        for (let i = 0; i < numLetters; i++) {
            const letter = i === correctIndex ? 
                this.currentLetter : 
                alphabet[Phaser.Math.Between(0, 25)];

            const pos = positions[i];
            this.createLetterButton(letter, pos.x, pos.y);
        }
    }

    generateRandomPositions(count) {
        const positions = [];
        const padding = 100;
        const minDistance = 150;

        for (let i = 0; i < count; i++) {
            let x, y, valid;

            do {
                valid = true;
                x = Phaser.Math.Between(padding + 100, 1280 - padding - 100);
                y = Phaser.Math.Between(280, 600);

                // Verificar distância mínima
                for (let pos of positions) {
                    const distance = Phaser.Math.Distance.Between(x, y, pos.x, pos.y);
                    if (distance < minDistance) {
                        valid = false;
                        break;
                    }
                }
            } while (!valid);

            positions.push({ x, y });
        }

        return positions;
    }

    createLetterButton(letter, x, y) {
        const isCorrect = letter === this.currentLetter;
        const bgColor = isCorrect ? 0x4ade80 : 0xFFFFFF;
        const textColor = isCorrect ? '#FFFFFF' : '#333333';

        // Botão
        const button = this.add.rectangle(x, y, 120, 120, bgColor);
        button.setStrokeStyle(4, 0xFFB74D);
        button.setInteractive({ useHandCursor: true });
        button.letter = letter;
        button.isCorrect = isCorrect;

        // Texto
        const text = this.add.text(x, y, letter, {
            fontSize: '64px',
            fontFamily: 'Fredoka',
            fill: textColor,
            fontStyle: 'bold',
            align: 'center'
        }).setOrigin(0.5);

        // Eventos
        button.on('pointerover', () => {
            this.tweens.add({
                targets: button,
                scaleX: 1.15,
                scaleY: 1.15,
                duration: 100
            });
            this.tweens.add({
                targets: text,
                scale: 1.15,
                duration: 100
            });
        });

        button.on('pointerout', () => {
            this.tweens.add({
                targets: button,
                scaleX: 1.0,
                scaleY: 1.0,
                duration: 100
            });
            this.tweens.add({
                targets: text,
                scale: 1.0,
                duration: 100
            });
        });

        button.on('pointerdown', () => {
            this.handleLetterClick(button, text);
        });

        this.letterObjects.push(button);
        this.letterObjects.push(text);
    }

    handleLetterClick(button, textObj) {
        if (!this.gameActive) return;

        const reactionTime = Date.now() - this.roundStartTime;
        this.reactionTimes.push(reactionTime);

        if (button.isCorrect) {
            // Acerto!
            const score = Math.max(10 - Math.floor(reactionTime / 500), 5);
            this.registry.set('score', this.registry.get('score') + score);
            this.registry.set('hits', this.registry.get('hits') + 1);
            this.scoreText.setText('Pontos: ' + this.registry.get('score'));

            // Animação de sucesso
            this.cameras.main.flash(300, 76, 222, 128);
            this.tweens.add({
                targets: button,
                scale: 1.3,
                duration: 200,
                yoyo: true,
                onComplete: () => {
                    this.startNewRound();
                }
            });

            // Feedback visual
            this.createParticles(button.x, button.y, '#4ade80');
        } else {
            // Erro
            this.registry.set('errors', this.registry.get('errors') + 1);

            // Animação de erro
            this.tweens.add({
                targets: button,
                x: button.x + 10,
                duration: 50,
                yoyo: true,
                repeat: 3
            });

            this.cameras.main.shake(200, 0.01);
        }
    }

    createParticles(x, y, color) {
        for (let i = 0; i < 10; i++) {
            const particle = this.add.circle(x, y, 8, Phaser.Display.Color.HexStringToColor(color).color);
            this.tweens.add({
                targets: particle,
                x: x + Phaser.Math.Between(-100, 100),
                y: y + Phaser.Math.Between(-100, 100),
                alpha: 0,
                duration: 600,
                ease: 'Quad.easeOut',
                onComplete: () => particle.destroy()
            });
        }
    }

    playLetterAudio(letter) {
        // Aqui seria reproduzido o áudio real
        // this.sound.play(`letter_${letter.toLowerCase()}`);
        console.log(`Reproduzindo áudio da letra: ${letter}`);
    }

    updateTimer() {
        if (!this.gameActive) return;

        this.timeLeft--;
        this.timeText.setText(`Tempo: ${this.timeLeft}s`);

        if (this.timeLeft <= 0) {
            this.endGame();
        }
    }

    endGame() {
        this.gameActive = false;

        // Calcular estrelas
        const hitRate = (this.registry.get('hits') / (this.registry.get('hits') + this.registry.get('errors'))) * 100;
        let stars = 1;
        if (hitRate >= 90) stars = 3;
        else if (hitRate >= 70) stars = 2;

        this.registry.set('stars', stars);

        // Passar para tela de recompensa
        this.scene.start('RewardScene');
    }

    onScreenClick(pointer) {
        // Usado para detecção geral
    }

    update() {
        // Update loop
    }
}

/**
 * CENA 4: REWARD SCENE
 * Tela de recompensa e resultados
 */
class RewardScene extends Phaser.Scene {
    constructor() {
        super({ key: 'RewardScene' });
    }

    create() {
        // Fundo
        const graphics = this.make.graphics({ x: 0, y: 0, add: false });
        graphics.fillStyle(0x87ceeb, 1);
        graphics.fillRect(0, 0, 1280, 720);
        graphics.generateTexture('rewardBg', 1280, 720);
        graphics.destroy();

        this.add.image(640, 360, 'rewardBg');

        // Dados da sessão
        const score = this.registry.get('score');
        const hits = this.registry.get('hits');
        const errors = this.registry.get('errors');
        const stars = this.registry.get('stars');

        // Título
        this.add.text(640, 100, 'Parabéns! 🎉', {
            fontSize: '60px',
            fontFamily: 'Fredoka',
            fill: '#333333',
            fontStyle: 'bold',
            align: 'center'
        }).setOrigin(0.5);

        // Estrelas
        this.drawStars(640, 200, stars);

        // Estatísticas
        const stats = [
            `Pontos: ${score}`,
            `Acertos: ${hits}`,
            `Erros: ${errors}`,
            `Taxa de Acerto: ${Math.round((hits / (hits + errors)) * 100)}%`
        ];

        let yPos = 320;
        stats.forEach(stat => {
            this.add.text(640, yPos, stat, {
                fontSize: '28px',
                fontFamily: 'Nunito',
                fill: '#333333',
                align: 'center'
            }).setOrigin(0.5);
            yPos += 50;
        });

        // Botão Jogar Novamente
        const replayButton = this.add.rectangle(400, 600, 280, 80, 0x4ade80);
        replayButton.setInteractive({ useHandCursor: true });

        this.add.text(400, 600, 'JOGAR NOVAMENTE', {
            fontSize: '24px',
            fontFamily: 'Baloo 2',
            fill: '#FFFFFF',
            fontStyle: 'bold',
            align: 'center'
        }).setOrigin(0.5);

        replayButton.on('pointerdown', () => {
            this.registry.set('score', 0);
            this.registry.set('hits', 0);
            this.registry.set('errors', 0);
            this.registry.set('stars', 0);
            this.scene.start('MenuScene');
        });

        // Botão Voltar
        const backButton = this.add.rectangle(880, 600, 280, 80, 0xff6f6f);
        backButton.setInteractive({ useHandCursor: true });

        this.add.text(880, 600, 'VOLTAR', {
            fontSize: '24px',
            fontFamily: 'Baloo 2',
            fill: '#FFFFFF',
            fontStyle: 'bold',
            align: 'center'
        }).setOrigin(0.5);

        backButton.on('pointerdown', () => {
            window.location.href = '/games';
        });
    }

    drawStars(x, y, count) {
        const starSize = 60;
        const spacing = 80;

        for (let i = 0; i < 3; i++) {
            const starX = x - spacing + (i * spacing);
            const filled = i < count;
            const color = filled ? 0xFFC107 : 0xDDDDDD;

            const star = this.add.polygon(starX, y, [
                [0, -starSize],
                [starSize * 0.3, -starSize * 0.3],
                [starSize, -starSize * 0.2],
                [starSize * 0.4, starSize * 0.2],
                [starSize * 0.6, starSize],
                [0, starSize * 0.5],
                [-starSize * 0.6, starSize],
                [-starSize * 0.4, starSize * 0.2],
                [-starSize, -starSize * 0.2],
                [-starSize * 0.3, -starSize * 0.3]
            ], color);

            if (filled) {
                this.tweens.add({
                    targets: star,
                    scale: 1.1,
                    duration: 300,
                    yoyo: true,
                    delay: i * 200
                });
            }
        }
    }
}

/**
 * CENA 5: GAME OVER SCENE
 * Tela de fim de jogo (não utilizada neste MVP, mas mantida para expansão)
 */
class GameOverScene extends Phaser.Scene {
    constructor() {
        super({ key: 'GameOverScene' });
    }

    create() {
        this.add.text(640, 360, 'Fim de Jogo', {
            fontSize: '60px',
            fill: '#FF0000',
            align: 'center'
        }).setOrigin(0.5);
    }
}