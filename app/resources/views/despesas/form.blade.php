@extends('layouts.app')
@section('title', $despesa->exists ? 'Editar despesa' : 'Nova despesa')
@section('content')
    <a class="back-link" href="{{ route('despesas.index') }}">← Voltar para despesas</a>
    <div class="page-heading"><div><p class="eyebrow">CADA REGISTRO FAZ DIFERENÇA</p><h1>{{ $despesa->exists ? 'Editar despesa' : 'Nova despesa' }}</h1><p>Preencha os detalhes do gasto. Todos os campos são obrigatórios.</p></div></div>
    <div class="form-layout">
        <section class="card form-card" aria-label="Dados da despesa">
            @if ($errors->any())<div class="notice error" role="alert">Revise os campos destacados e tente novamente.</div>@endif
            <form action="{{ $despesa->exists ? route('despesas.update', $despesa) : route('despesas.store') }}" method="POST">
                @csrf
                @if ($despesa->exists) @method('PUT') @endif
                <div class="field">
                    <label for="descricao">Descrição</label>
                    <input id="descricao" name="descricao" type="text" value="{{ old('descricao', $despesa->descricao) }}" maxlength="150" placeholder="Ex.: Compras da semana" required @error('descricao') aria-invalid="true" aria-describedby="descricao-erro" @enderror>
                    @error('descricao')<p class="field-error" id="descricao-erro">{{ $message }}</p>@enderror
                </div>
                <div class="form-row">
                    <div class="field">
                        <label for="valor">Valor (R$)</label>
                        <input id="valor" name="valor" type="text" inputmode="decimal" value="{{ old('valor', $despesa->exists ? str_replace('.', ',', $despesa->valor) : '') }}" placeholder="0,00" required aria-describedby="valor-ajuda{{ $errors->has('valor') ? ' valor-erro' : '' }}" @error('valor') aria-invalid="true" @enderror>
                        <p class="field-help" id="valor-ajuda">Use vírgula ou ponto para os centavos, sem separador de milhar.</p>
                        @error('valor')<p class="field-error" id="valor-erro">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="data">Data da despesa</label>
                        <input id="data" name="data" type="date" value="{{ old('data', $despesa->data?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required @error('data') aria-invalid="true" aria-describedby="data-erro" @enderror>
                        @error('data')<p class="field-error" id="data-erro">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="field">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" required @error('categoria') aria-invalid="true" aria-describedby="categoria-erro" @enderror>
                        <option value="">Selecione uma categoria</option>
                        @foreach (\App\Models\Despesa::CATEGORIAS as $categoria)
                            <option value="{{ $categoria }}" @selected(old('categoria', $despesa->categoria) === $categoria)>{{ $categoria }}</option>
                        @endforeach
                    </select>
                    @error('categoria')<p class="field-error" id="categoria-erro">{{ $message }}</p>@enderror
                </div>
                <div class="form-actions"><a class="button secondary" href="{{ route('despesas.index') }}">Cancelar</a><button class="button primary" type="submit">{{ $despesa->exists ? 'Salvar alterações' : 'Cadastrar despesa' }}</button></div>
            </form>
        </section>
        <aside class="tip"><span class="tip-label">UM HÁBITO MAIS LEVE</span><h2>Os pequenos gastos também contam.</h2><p>Registrar as despesas no dia a dia ajuda você a entender para onde seu dinheiro vai.</p><div class="tip-line"></div><p>Escolha uma descrição fácil de reconhecer e a categoria que melhor representa o gasto.</p></aside>
    </div>
@endsection
