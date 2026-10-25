# SaldoLeve

Controle de despesas pessoais feito com Laravel 12, PHP 8.2+, PostgreSQL, Blade, CSS e JavaScript.

## Funcionalidades

- Cadastro, listagem, edição e exclusão de despesas.
- Descrição, valor em reais, categoria e data.
- Validação em português, paginação e confirmação de exclusão.

## Executar localmente

Na pasta `app`:

```sh
composer install
cp .env.example .env
php artisan key:generate
```

Crie um banco PostgreSQL exclusivo chamado `saldo_leve` e configure `DB_HOST`, `DB_PORT`, `DB_USERNAME` e `DB_PASSWORD` no `.env` local. Depois execute:

```sh
php artisan migrate
php artisan serve
```

Acesse http://localhost:8000. O CSS e o JavaScript desta versão são servidos diretamente de `public`, sem exigir uma compilação do frontend.

O `.env` contém segredos e não deve ser versionado. Apenas `.env.example`, sem credenciais, acompanha o repositório.

## Testes

```sh
php artisan test
```

Os testes usam SQLite em memória, com `pdo_sqlite` habilitado, e não alteram o banco PostgreSQL configurado no `.env`.

## Fluxo de trabalho

- `main`: versões estáveis.
- `development`: integração das funcionalidades.
- `feat/cadastro-despesas`: implementação do CRUD inicial.

Esta versão é para uso local e ainda não inclui autenticação. Filtros mensais e resumo dos gastos são os próximos passos.
