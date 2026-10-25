@extends('layouts.app')
@section('title', 'Minhas despesas')
@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">ORGANIZE O DIA A DIA</p><h1>Minhas despesas</h1><p>Acompanhe seus gastos e mantenha tudo em ordem.</p></div>
        <a class="button primary" href="{{ route('despesas.create') }}"><span aria-hidden="true">+</span> Nova despesa</a>
    </div>
    <section class="card" aria-labelledby="lista-titulo">
        <div class="card-heading"><h2 id="lista-titulo">Seus registros</h2><span class="counter">{{ $despesas->total() }} {{ $despesas->total() === 1 ? 'despesa' : 'despesas' }}</span></div>
        @if ($despesas->isEmpty())
            <div class="empty-state">
                <span class="empty-icon" aria-hidden="true">+</span>
                <h2>{{ $despesas->total() ? 'Nenhum registro nesta página' : 'Seu controle começa aqui' }}</h2>
                <p>{{ $despesas->total() ? 'Volte para a primeira página para ver suas despesas.' : 'Cadastre sua primeira despesa e dê o primeiro passo para uma vida financeira mais leve.' }}</p>
                <a class="button primary" href="{{ $despesas->total() ? route('despesas.index') : route('despesas.create') }}">{{ $despesas->total() ? 'Ver despesas' : 'Cadastrar primeira despesa' }}</a>
            </div>
        @else
            <div class="table-scroll">
                <table>
                    <caption class="sr-only">Despesas ordenadas da data mais recente para a mais antiga</caption>
                    <thead><tr><th scope="col">Descrição</th><th scope="col">Categoria</th><th scope="col">Data</th><th scope="col" class="numeric">Valor</th><th scope="col" class="numeric">Ações</th></tr></thead>
                    <tbody>
                    @foreach ($despesas as $despesa)
                        <tr>
                            <th scope="row">{{ $despesa->descricao }}</th>
                            <td><span class="badge">{{ $despesa->categoria }}</span></td>
                            <td class="date">{{ $despesa->data->format('d/m/Y') }}</td>
                            <td class="amount numeric">R$ {{ number_format((float) $despesa->valor, 2, ',', '.') }}</td>
                            <td><div class="actions">
                                <a class="text-link" href="{{ route('despesas.edit', $despesa) }}" aria-label="Editar {{ $despesa->descricao }}">Editar</a>
                                <form action="{{ route('despesas.destroy', $despesa) }}" method="POST" data-confirm-delete>
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-link danger" type="submit" aria-label="Excluir {{ $despesa->descricao }}">Excluir</button>
                                </form>
                            </div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if ($despesas->hasPages())
            <nav class="pagination" aria-label="Paginação das despesas">
                @if ($despesas->onFirstPage())<span aria-disabled="true">Anterior</span>@else<a href="{{ $despesas->previousPageUrl() }}" rel="prev">Anterior</a>@endif
                <span>Página {{ $despesas->currentPage() }} de {{ $despesas->lastPage() }}</span>
                @if ($despesas->hasMorePages())<a href="{{ $despesas->nextPageUrl() }}" rel="next">Próxima</a>@else<span aria-disabled="true">Próxima</span>@endif
            </nav>
        @endif
    </section>
@endsection
