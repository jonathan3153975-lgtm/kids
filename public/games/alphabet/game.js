class AlphabetGame extends Phaser.Scene {
    constructor() {
        super({ key: 'AlphabetGame' });
        this.score = 0;
        this.timeLeft = 60;
        this.letters = [];
        this.targetLetter = '';
        this.gameStarted = false;
    }

    preload() {
        // Carregar assets (usaremos formas geométricas por enquanto)
        this.load.image('background', 'data:image/svg+xml;base64,' + btoa(`
            <svg width="800" height="600" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="sky" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#87CEEB"/>
                        <stop offset="100%" style="stop-color:#E0F6FF"/>
                    </linearGradient>
                </defs>
                <rect width="800" height="600" fill="url(#sky)"/>
                <circle cx="100" cy="100" r="30" fill="#FFFACD" opacity="0.8"/>
                <circle cx="150" cy="80" r="25" fill="#FFFACD" opacity="0.6"/>
                <circle cx="200" cy="120" r="35" fill="#FFFACD" opacity="0.7"/>
            </svg>
        `));
    }

    create() {
        // Fundo
        this.add.image(400, 300, 'background');

        // Texto de instrução inicial
        this.instructionText = this.add.text(400, 200, 'Clique para começar!\nEncontre a letra destacada', {
            fontSize: '32px',
            fill: '#25415d',
            align: 'center',
            fontWeight: 'bold'
        }).setOrigin(0.5);

        // Texto da letra alvo
        this.targetText = this.add.text(400, 100, '', {
            fontSize: '48px',
            fill: '#ff6f6f',
            fontWeight: 'bold'
        }).setOrigin(0.5);

        // Pontuação
        this.scoreText = this.add.text(50, 50, 'Pontos: 0', {
            fontSize: '24px',
            fill: '#25415d',
            fontWeight: 'bold'
        });

        // Tempo
        this.timeText = this.add.text(650, 50, 'Tempo: 60s', {
            fontSize: '24px',
            fill: '#25415d',
            fontWeight: 'bold'
        });

        // Clique para iniciar
        this.input.on('pointerdown', () => {
            if (!this.gameStarted) {
                this.startGame();
            }
        });

        // Timer
        this.time.addEvent({
            delay: 1000,
            callback: this.updateTimer,
            callbackScope: this,
            loop: true
        });
    }

    startGame() {
        this.gameStarted = true;
        this.instructionText.destroy();

        // Escolher letra alvo aleatória
        const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        this.targetLetter = alphabet[Math.floor(Math.random() * alphabet.length)];

        this.targetText.setText(`Encontre: ${this.targetLetter}`);

        // Criar letras na tela
        this.createLetters();
    }

    createLetters() {
        // Limpar letras anteriores
        this.letters.forEach(letter => letter.destroy());
        this.letters = [];

        const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numLetters = 8;

        for (let i = 0; i < numLetters; i++) {
            const x = Phaser.Math.Between(100, 700);
            const y = Phaser.Math.Between(200, 500);
            const letter = alphabet[Math.floor(Math.random() * alphabet.length)];

            const letterSprite = this.add.text(x, y, letter, {
                fontSize: '36px',
                fill: letter === this.targetLetter ? '#ff6f6f' : '#25415d',
                fontWeight: 'bold',
                backgroundColor: '#ffffff',
                padding: { x: 10, y: 5 },
                borderRadius: 10
            }).setOrigin(0.5).setInteractive();

            letterSprite.letter = letter;
            letterSprite.on('pointerdown', () => this.onLetterClick(letterSprite));
            letterSprite.on('pointerover', () => this.onLetterHover(letterSprite, true));
            letterSprite.on('pointerout', () => this.onLetterHover(letterSprite, false));

            this.letters.push(letterSprite);
        }

        // Garantir que pelo menos uma letra alvo esteja presente
        if (!this.letters.some(l => l.letter === this.targetLetter)) {
            const randomIndex = Math.floor(Math.random() * this.letters.length);
            this.letters[randomIndex].setText(this.targetLetter);
            this.letters[randomIndex].letter = this.targetLetter;
            this.letters[randomIndex].setFill('#ff6f6f');
        }
    }

    onLetterClick(letterSprite) {
        if (!this.gameStarted) return;

        if (letterSprite.letter === this.targetLetter) {
            this.score += 10;
            this.scoreText.setText(`Pontos: ${this.score}`);

            // Animação de acerto
            this.tweens.add({
                targets: letterSprite,
                scale: 1.5,
                duration: 200,
                yoyo: true,
                onComplete: () => {
                    this.createLetters();
                }
            });

            // Efeito sonoro (simulado)
            this.cameras.main.flash(200, 0, 255, 0);
        } else {
            // Animação de erro
            this.tweens.add({
                targets: letterSprite,
                x: letterSprite.x + 10,
                duration: 50,
                yoyo: true,
                repeat: 3
            });

            this.cameras.main.shake(200, 0.01);
        }
    }

    onLetterHover(letterSprite, isHover) {
        if (isHover) {
            letterSprite.setScale(1.1);
        } else {
            letterSprite.setScale(1.0);
        }
    }

    updateTimer() {
        if (!this.gameStarted) return;

        this.timeLeft--;
        this.timeText.setText(`Tempo: ${this.timeLeft}s`);

        if (this.timeLeft <= 0) {
            this.endGame();
        }
    }

    endGame() {
        this.gameStarted = false;

        // Tela de fim de jogo
        const gameOverText = this.add.text(400, 250, 'Tempo esgotado!', {
            fontSize: '48px',
            fill: '#ff6f6f',
            fontWeight: 'bold'
        }).setOrigin(0.5);

        const finalScoreText = this.add.text(400, 320, `Pontuação Final: ${this.score}`, {
            fontSize: '32px',
            fill: '#25415d',
            fontWeight: 'bold'
        }).setOrigin(0.5);

        const restartText = this.add.text(400, 400, 'Clique para jogar novamente', {
            fontSize: '24px',
            fill: '#666',
        }).setOrigin(0.5);

        // Reset do jogo
        this.input.on('pointerdown', () => {
            this.scene.restart();
        });
    }
}

const config = {
    type: Phaser.AUTO,
    width: 800,
    height: 600,
    scene: AlphabetGame,
    backgroundColor: '#f4fbff',
    parent: 'game-container'
};

const game = new Phaser.Game(config);