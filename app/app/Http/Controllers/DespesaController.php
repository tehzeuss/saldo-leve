<?php

namespace App\Http\Controllers;

use App\Http\Requests\DespesaRequest;
use App\Models\Despesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DespesaController extends Controller
{
    public function index(): View
    {
        return view('despesas.index', [
            'despesas' => Despesa::query()->orderByDesc('data')->orderByDesc('id')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('despesas.form', ['despesa' => new Despesa]);
    }

    public function store(DespesaRequest $request): RedirectResponse
    {
        Despesa::create($request->validated());

        return to_route('despesas.index')->with('sucesso', 'Despesa cadastrada com sucesso.');
    }

    public function edit(Despesa $despesa): View
    {
        return view('despesas.form', compact('despesa'));
    }

    public function update(DespesaRequest $request, Despesa $despesa): RedirectResponse
    {
        $despesa->update($request->validated());

        return to_route('despesas.index')->with('sucesso', 'Despesa atualizada com sucesso.');
    }

    public function destroy(Despesa $despesa): RedirectResponse
    {
        $despesa->delete();

        return to_route('despesas.index')->with('sucesso', 'Despesa excluída com sucesso.');
    }
}
