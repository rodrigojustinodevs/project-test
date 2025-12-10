<?php

namespace App\Http\Controllers;

use App\Http\Services\CpfFormatterService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class CpfController extends Controller
{

    public function processCpfs(Request $request, CpfFormatterService $formatterService): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'cpfs' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos na requisição',
                'errors' => $validator->errors()
            ], 422);
        }

        $cpfsString = (string)$request->input('cpfs', '');
        
        $cpfsToProcess = $this->prepareCpfList($cpfsString);

        if ($cpfsToProcess->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Nenhum CPF fornecido para processamento',
                'data' => []
            ], 200);
        }
        
        $formattedCpfs = $cpfsToProcess->map(function ($cpf) use ($formatterService) {
            return $formatterService->format($cpf);
        })->values();

        return response()->json([
            'success' => true,
            'message' => 'CPFs processados e formatados com sucesso',
            'data' => $formattedCpfs,
        ], 200);
    }

    private function prepareCpfList(string $cpfsString): Collection
    {
        $normalized = str_replace(',', ';', $cpfsString);
        
        return collect(explode(';', $normalized))
            ->map(fn($cpf) => trim($cpf))
            ->filter(fn($cpf) => !empty($cpf))
            ->values();
    }
}