<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#174b40">
    <title>@yield('title', 'Despesas') · SaldoLeve</title>
    <link rel="stylesheet" href="{{ asset('css/saldo-leve.css') }}">
    <script src="{{ asset('js/saldo-leve.js') }}" defer></script>
</head>
<body>
    <header class="header">
        <div class="shell header-inner">
            <a class="brand" href="{{ route('despesas.index') }}" aria-label="SaldoLeve, início"><span class="brand-icon" aria-hidden="true">S</span>Saldo<span>Leve</span></a>
            <span class="header-caption">Seu dinheiro, com mais clareza.</span>
        </div>
    </header>
    <main class="shell">
        <nav class="section-nav" aria-label="Navegação principal"><a href="{{ route('despesas.index') }}" aria-current="page">Minhas despesas</a></nav>
        @if (session('sucesso'))
            <div class="notice success" role="status">{{ session('sucesso') }}</div>
        @endif
        @yield('content')
    </main>
    <footer class="shell footer">SaldoLeve <span>Um passo de cada vez para organizar suas finanças.</span></footer>
</body>
</html>
