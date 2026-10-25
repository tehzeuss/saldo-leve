<?php

namespace App\Http\Requests;

use App\Models\Despesa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DespesaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $valor = $this->input('valor');

        if (is_string($valor) && preg_match('/^\d+,\d{1,2}$/', trim($valor))) {
            $this->merge(['valor' => str_replace(',', '.', trim($valor))]);
        }
    }

    public function rules(): array
    {
        return [
            'descricao' => ['required', 'string', 'max:150'],
            'valor' => ['bail', 'required', 'numeric', 'decimal:0,2', 'gt:0', 'max:99999999.99'],
            'categoria' => ['required', 'string', Rule::in(Despesa::CATEGORIAS)],
            'data' => ['required', 'date_format:Y-m-d'],
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required' => 'Informe a descrição da despesa.',
            'descricao.string' => 'Informe uma descrição válida.',
            'descricao.max' => 'A descrição deve ter no máximo 150 caracteres.',
            'valor.required' => 'Informe o valor da despesa.',
            'valor.numeric' => 'Informe um valor numérico válido.',
            'valor.decimal' => 'Use no máximo duas casas decimais no valor.',
            'valor.gt' => 'O valor deve ser maior que zero.',
            'valor.max' => 'O valor máximo permitido é R$ 99.999.999,99.',
            'categoria.required' => 'Selecione uma categoria.',
            'categoria.string' => 'Selecione uma categoria válida.',
            'categoria.in' => 'Selecione uma das categorias disponíveis.',
            'data.required' => 'Informe a data da despesa.',
            'data.date_format' => 'Informe uma data válida.',
        ];
    }
}
