<?php
namespace App\Services;
use App\Models\plant_scanner;
class PlantScannerService
{
    public function getAll()
    {
        return plant_scanner::all();
    }

   public function create(array $data)
    {
        
        return plant_scanner::create($data);
    }


   public function checkQrCode(string $qrCode): bool
    {
        return plant_scanner::where('qr_code', $qrCode)->exists();
    }
}

?>