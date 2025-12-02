<?php
namespace App\Services;
use App\Models\fruit_scanner;
class FruitScannerService
{
    public function getAll()
    {
        return fruit_scanner::all();
    }

   public function create(array $data)
    {
        
        return fruit_scanner::create($data);
    }


   public function checkQrCode(string $qrCode): bool
    {
        return fruit_scanner::where('fruit_qr_code', $qrCode)->exists();
    }
}

?>