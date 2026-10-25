<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    protected $table = 'despesas';

    protected $fillable = ['descricao', 'valor', 'categoria', 'data'];

    public const CATEGORIAS = [
        'Alimentação', 'Moradia', 'Transporte', 'Saúde',
        'Educação', 'Lazer', 'Compras', 'Outros',
    ];

    protected function casts(): array
    {
        return ['valor' => 'decimal:2', 'data' => 'date'];
    }
}
