<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_inicio_redireciona_para_despesas(): void
    {
        $this->get('/')->assertRedirect('/despesas');
    }
}
