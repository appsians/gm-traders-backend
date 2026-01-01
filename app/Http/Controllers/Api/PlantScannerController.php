<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PlantScannerRequest;
use App\Services\PlantScannerService;


use Illuminate\Http\JsonResponse;


class PlantScannerController extends Controller
{
     protected $plantscannerService;

    public function __construct(PlantScannerService $plantscannerService)
        {
            $this->plantscannerService = $plantscannerService;
        }

        public function showPlantData(){
            return $this->plantscannerService->getAll();
        }
     public function store(PlantScannerRequest $request): JsonResponse
        {
            $plant = $this->plantscannerService->create($request->validated());
            return response()->json([
                'success' => true,
                'data' => 'Plant data store successfully',
            ], 201);
        }

    public function checkQrCode(Request $request): JsonResponse
        {
            $request->validate([
                'qr_code' => 'required|string',
            ]);

            $exists = $this->plantscannerService->checkQrCode($request->qr_code);

            return response()->json([
                'exists' => $exists,
            ]);
        }


}
