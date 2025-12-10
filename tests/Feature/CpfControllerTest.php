<?php

namespace Tests\Feature;

use Tests\TestCase;

class CpfControllerTest extends TestCase
{
    public function test_processa_cpfs_separados_por_ponto_e_virgula(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => '12345678901;98765432100;11122233344'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'CPFs processados e formatados com sucesso',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => []
                ]
            ]);

        $data = $response->json('data');
        $this->assertCount(3, $data);
        $this->assertEquals('123.456.789-01', $data[0]);
        $this->assertEquals('987.654.321-00', $data[1]);
        $this->assertEquals('111.222.333-44', $data[2]);
    }

    public function test_processa_cpfs_separados_por_virgula(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => '12345678901,98765432100'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $data = $response->json('data');
        $this->assertCount(2, $data);
        $this->assertEquals('123.456.789-01', $data[0]);
        $this->assertEquals('987.654.321-00', $data[1]);
    }

    public function test_processa_cpfs_com_espacos(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => ' 12345678901 ; 98765432100 ; 11122233344 '
        ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(3, $data);
    }

    public function test_processa_cpf_unico(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => '12345678901'
        ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('123.456.789-01', $data[0]);
    }

    public function test_processa_cpfs_com_menos_de_11_digitos(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => '123456789;987654321'
        ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(2, $data);
        $this->assertEquals('001.234.567-89', $data[0]);
        $this->assertEquals('009.876.543-21', $data[1]);
    }

    public function test_processa_string_vazia(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => ''
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Nenhum CPF fornecido para processamento',
                'data' => []
            ]);
    }

    public function test_processa_sem_campo_cpfs(): void
    {
        $response = $this->postJson('/api/processar-cpfs', []);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Nenhum CPF fornecido para processamento',
                'data' => []
            ]);
    }

    public function test_processa_cpfs_com_caracteres_especiais(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => '123.456.789-01;987.654.321-00'
        ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(2, $data);
        $this->assertEquals('123.456.789-01', $data[0]);
        $this->assertEquals('987.654.321-00', $data[1]);
    }

    public function test_processa_cpfs_com_separadores_mistos(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => '12345678901,98765432100;11122233344'
        ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(3, $data);
    }

    public function test_processa_cpfs_com_entradas_vazias(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => '12345678901;;98765432100;  ;11122233344'
        ]);

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(3, $data);
        $this->assertEquals('123.456.789-01', $data[0]);
        $this->assertEquals('987.654.321-00', $data[1]);
        $this->assertEquals('111.222.333-44', $data[2]);
    }

    public function test_valida_tipo_invalido(): void
    {
        $response = $this->postJson('/api/processar-cpfs', [
            'cpfs' => 12345
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Dados inválidos na requisição',
            ])
            ->assertJsonValidationErrors(['cpfs']);
    }
}

