<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected StoreService $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function index()
    {
        return response()->json($this->storeService->getAll(), 200);
    }

    public function show($id)
    {
        return response()->json($this->storeService->getById($id), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:100',
            'plant_type' => 'nullable|string|max:100',
            'height' => 'nullable|integer',
            'humidity' => 'nullable|integer',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'image' => 'nullable|string',
        ]);

        $store = $this->storeService->create($validated);

        return response()->json($store, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:100',
            'plant_type' => 'nullable|string|max:100',
            'height' => 'nullable|integer',
            'humidity' => 'nullable|integer',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric',
            'discount_price' => 'nullable|numeric',
            'image' => 'nullable|string',
        ]);

        $store = $this->storeService->update($validated, $id);

        return response()->json($store, 200);
    }

    public function destroy($id)
    {
        $this->storeService->delete($id);
        return response()->json(['message' => 'Store item deleted successfully'], 200);
    }
}

