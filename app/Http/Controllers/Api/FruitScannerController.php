<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FruitScannerRequest;
use App\Services\FruitScannerService;
use Illuminate\Http\JsonResponse;

class FruitScannerController extends Controller
{
     protected $fruitcannerService;

    public function __construct(FruitScannerService $fruitcannerService)
        {
            $this->fruitcannerService = $fruitcannerService;
        }

    public function showFruitData(){
            return $this->fruitcannerService->getAll();
    }
    public function store(FruitScannerRequest $request): JsonResponse
        {
            $plant = $this->fruitcannerService->create($request->validated());
            return response()->json([
                'success' => true,
                'data' => 'Plant data store successfully',
            ], 201);
        }

    public function checkQrCode(Request $request): JsonResponse
        {
            $request->validate([
                'fruit_qr_code' => 'required|string',
            ]);
            $exists = $this->fruitcannerService->checkQrCode($request->fruit_qr_code);
            return response()->json([
                'exists' => $exists,
            ]);
        }

}
