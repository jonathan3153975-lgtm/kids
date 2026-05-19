# Kids Platform - Servidor de Desenvolvimento

## Problema Resolvido

O servidor PHP embutido (`php -S`) não consegue processar corretamente as regras de roteamento definidas no `.htaccess`, causando erro 404 para rotas como `/games`.

## Solução

Criamos um servidor proxy em Python que executa o PHP com as variáveis de ambiente corretas para roteamento.

## Como Usar

### 1. Iniciar o Servidor

```bash
cd /caminho/para/kids
python server.py
```

O servidor iniciará na porta 8080: http://localhost:8080

### 2. Acessar a Aplicação

- **Login**: http://localhost:8080/login
  - Email: parent@kids.local
  - Senha: 123456

- **Dashboard**: http://localhost:8080/dashboard
- **Jogos**: http://localhost:8080/games
- **Jogo do Alfabeto**: http://localhost:8080/games/alphabet

### 3. Funcionalidades Verificadas

✅ Rota `/games` funciona (lista de jogos)
✅ Rota `/games/alphabet` funciona (jogo do alfabeto)
✅ Autenticação funciona
✅ Navegação entre páginas funciona
✅ Arquivos estáticos (CSS, JS, imagens) são servidos

## Arquivos do Servidor

- `server.py`: Servidor proxy Python que executa PHP
- `public/index.php`: Ponto de entrada da aplicação PHP
- `core/Router.php`: Sistema de roteamento
- `app/Controllers/`: Controladores da aplicação

## Comandos Úteis

```bash
# Parar todos os servidores Python
Get-Process python | Stop-Process -Force

# Verificar se a porta 8080 está livre
netstat -ano | findstr :8080
```