<?php
// app/Services/StoreService.php
namespace App\Services;

use App\Models\Store;

class StoreService
{
    public function getAll()
    {
        return Store::with('category')->get();
    }

    public function getById($id)
    {
        return Store::with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Store::create($data);
    }

    public function update(array $data, $id)
    {
        $store = Store::findOrFail($id);
        $store->update($data);
        return $store;
    }

    public function delete($id)
    {
        $store = Store::findOrFail($id);
        return $store->delete();
    }
}

