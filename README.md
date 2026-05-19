# Kids Platform

Base inicial da plataforma educacional infantil gamificada descrita nos documentos do projeto.

## O que esta pronto

- estrutura web em PHP com MVC leve;
- layout responsivo com Bootstrap 5 customizado para publico infantil;
- autenticacao demo para responsavel e administrador;
- dashboard inicial;
- cadastro local de criancas em sessao;
- catalogo inicial de jogos;
- API REST demo com health check, login, listagem de jogos e criancas;
- script SQL completo para MariaDB.

## Estrutura

```txt
kids/
├── app/
├── config/
├── core/
├── database/
└── public/
```

## 🚀 Servidor de Desenvolvimento (Recomendado)

Devido a limitações do servidor PHP embutido com roteamento, usamos um servidor proxy Python:

```bash
# Instalar dependências (se necessário)
composer install

# Iniciar servidor
python server.py
```

Acesse: http://localhost:8080

### Credenciais de Teste

- **Email**: parent@kids.local
- **Senha**: 123456

### Páginas Disponíveis

- **Login**: `/login`
- **Dashboard**: `/dashboard`
- **Jogos**: `/games`
- **Jogo do Alfabeto**: `/games/alphabet`
- **Crianças**: `/children`

## Rodar localmente

### Opcao 1: servidor embutido do PHP

```bash
php -S localhost:8000 -t public
```

Depois abra http://localhost:8000.

### Contas demo

- Responsavel: parent@kids.local / 123456
- Administrador: admin@kids.local / 123456

## Banco de dados

O script completo esta em [database/schema.sql](database/schema.sql).

Para criar no MariaDB:

```sql
SOURCE database/schema.sql;
```

## Proximo passo natural

Conectar as rotas demo ao banco MariaDB com PDO e evoluir a API para JWT real.
