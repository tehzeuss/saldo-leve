<?php

namespace Tests\Feature;

use App\Models\Despesa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DespesaTest extends TestCase
{
    use RefreshDatabase;

    private function dados(array $overrides = []): array
    {
        return array_merge([
            'descricao' => 'Compras da semana',
            'valor' => '125.90',
            'categoria' => 'Alimentação',
            'data' => '2026-10-24',
        ], $overrides);
    }

    public function test_exibe_estado_vazio_e_formulario(): void
    {
        $this->get('/despesas')->assertOk()->assertSee('Seu controle começa aqui');
        $this->get('/despesas/create')->assertOk()->assertSee('Cadastrar despesa');
    }

    public function test_cadastra_valor_com_virgula_e_ignora_campos_extras(): void
    {
        $this->post('/despesas', $this->dados(['valor' => '125,90', 'id' => 500]))
            ->assertRedirect('/despesas')->assertSessionHas('sucesso');

        $despesa = Despesa::sole();
        $this->assertSame('125.90', $despesa->valor);
        $this->assertNotEquals(500, $despesa->id);
        $this->assertSame('2026-10-24', $despesa->data->format('Y-m-d'));
    }

    public function test_rejeita_campos_obrigatorios_sem_criar_registro(): void
    {
        $this->from('/despesas/create')->post('/despesas', [])
            ->assertRedirect('/despesas/create')
            ->assertSessionHasErrors(['descricao', 'valor', 'categoria', 'data']);
        $this->assertDatabaseCount('despesas', 0);
    }

    public function test_rejeita_valores_invalidos_datas_e_categorias(): void
    {
        foreach (['0', '-10', '1.999', '100000000', 'abc', '1.234,56', '1e2'] as $valor) {
            $this->post('/despesas', $this->dados(['valor' => $valor]))->assertSessionHasErrors('valor');
        }
        $this->post('/despesas', $this->dados(['categoria' => 'Inválida', 'data' => '2026-02-30', 'descricao' => str_repeat('a', 151)]))
            ->assertSessionHasErrors(['categoria', 'data', 'descricao']);
        $this->assertDatabaseCount('despesas', 0);
    }

    public function test_lista_em_ordem_com_paginacao_e_escapa_html(): void
    {
        for ($i = 1; $i <= 11; $i++) {
            Despesa::create($this->dados(['descricao' => 'Registro '.$i, 'data' => sprintf('2026-10-%02d', $i)]));
        }
        Despesa::create($this->dados(['descricao' => '<script>alert(1)</script>']));

        $this->get('/despesas')->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSeeInOrder(['Registro 11', 'Registro 10'])
            ->assertSee('R$ 125,90')->assertSee('Página 1 de 2');
        $this->get('/despesas?page=2')->assertOk()->assertSee('Registro 1');
    }

    public function test_edita_despesa_e_mantem_valores_apos_erro(): void
    {
        $despesa = Despesa::create($this->dados());
        $this->get('/despesas/'.$despesa->id.'/edit')->assertOk()->assertSee('Compras da semana');
        $this->from('/despesas/'.$despesa->id.'/edit')
            ->put('/despesas/'.$despesa->id, $this->dados(['valor' => '-2']))
            ->assertSessionHasErrors('valor')->assertSessionHasInput('valor', '-2');
        $this->assertSame('125.90', $despesa->fresh()->valor);

        $this->put('/despesas/'.$despesa->id, $this->dados(['descricao' => 'Mercado', 'valor' => '89.50']))
            ->assertRedirect('/despesas')->assertSessionHas('sucesso');
        $this->assertDatabaseHas('despesas', ['id' => $despesa->id, 'descricao' => 'Mercado', 'valor' => '89.50']);
    }

    public function test_exclui_somente_despesa_escolhida_e_retorna_404_para_inexistentes(): void
    {
        $primeira = Despesa::create($this->dados());
        $segunda = Despesa::create($this->dados(['descricao' => 'Outra despesa']));
        $this->delete('/despesas/'.$primeira->id)->assertRedirect('/despesas')->assertSessionHas('sucesso');
        $this->assertDatabaseMissing('despesas', ['id' => $primeira->id]);
        $this->assertModelExists($segunda);
        $this->get('/despesas/'.$primeira->id.'/edit')->assertNotFound();
        $this->put('/despesas/'.$primeira->id, $this->dados())->assertNotFound();
        $this->delete('/despesas/'.$primeira->id)->assertNotFound();
    }
}
