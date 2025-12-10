<?php

namespace Tests\Unit;

use App\Http\Services\CpfFormatterService;
use Tests\TestCase;

class CpfFormatterServiceTest extends TestCase
{
    private CpfFormatterService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CpfFormatterService();
    }

    public function test_formata_cpf_com_11_digitos(): void
    {
        $result = $this->service->format('12345678901');
        $this->assertEquals('123.456.789-01', $result);
    }

    public function test_formata_cpf_ja_formatado(): void
    {
        $result = $this->service->format('123.456.789-01');
        $this->assertEquals('123.456.789-01', $result);
    }

    public function test_formata_cpf_com_menos_de_11_digitos(): void
    {
        $result = $this->service->format('123456789');
        $this->assertEquals('001.234.567-89', $result);
    }

    public function test_formata_cpf_com_1_digito(): void
    {
        $result = $this->service->format('1');
        $this->assertEquals('000.000.000-01', $result);
    }

    public function test_formata_cpf_com_mais_de_11_digitos(): void
    {
        $result = $this->service->format('123456789012345');
        $this->assertEquals('123.456.789-01', $result);
    }

    public function test_formata_cpf_com_caracteres_especiais(): void
    {
        $result = $this->service->format('123.456.789-01');
        $this->assertEquals('123.456.789-01', $result);
    }

    public function test_formata_cpf_com_espacos(): void
    {
        $result = $this->service->format('123 456 789 01');
        $this->assertEquals('123.456.789-01', $result);
    }

    public function test_formata_cpf_vazio(): void
    {
        $result = $this->service->format('');
        $this->assertEquals('000.000.000-00', $result);
    }

    public function test_formata_cpf_com_zeros(): void
    {
        $result = $this->service->format('00000000000');
        $this->assertEquals('000.000.000-00', $result);
    }

    public function test_formata_cpf_com_letras(): void
    {
        $result = $this->service->format('abc12345678901def');
        $this->assertEquals('123.456.789-01', $result);
    }

    public function test_formata_cpf_com_10_digitos(): void
    {
        $result = $this->service->format('1234567890');
        $this->assertEquals('012.345.678-90', $result);
    }
}

