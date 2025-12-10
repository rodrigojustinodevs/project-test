<?php

namespace App\Http\Services;

class CpfFormatterService
{
    private const CPF_LENGTH = 11;
    private const FORMAT_MASK = '$1.$2.$3-$4';

    public function format(string $cpf): string
    {
        $cleanedCpf = $this->cleanCpf($cpf);

        $paddedCpf = $this->padCpf($cleanedCpf);

        return $this->applyMask($paddedCpf);
    }

    private function cleanCpf(string $cpf): string
    {
        return preg_replace('/\D/', '', $cpf);
    }

    private function padCpf(string $cpf): string
    {
        $cpf = substr($cpf, 0, self::CPF_LENGTH); 
        
        return str_pad($cpf, self::CPF_LENGTH, '0', STR_PAD_LEFT);
    }

    private function applyMask(string $cpf): string
    {
        if (strlen($cpf) !== self::CPF_LENGTH) {
            return $cpf;
        }

        return preg_replace(
            '/^(\d{3})(\d{3})(\d{3})(\d{2})$/', 
            self::FORMAT_MASK, 
            $cpf
        );
    }
}