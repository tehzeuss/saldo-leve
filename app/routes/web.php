<?php

use App\Http\Controllers\DespesaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/despesas');
Route::resource('despesas', DespesaController::class)
    ->parameters(['despesas' => 'despesa'])
    ->except('show');
