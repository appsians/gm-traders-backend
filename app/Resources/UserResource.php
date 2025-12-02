<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'phone'    => $this->phone,
            'location' => $this->location,
            'avatar'   => $this->avatar ? Storage::url($this->avatar) : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
    
}
