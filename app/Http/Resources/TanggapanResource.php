<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TanggapanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_pengaduan' => $this->id_user,
            'ditanggapi_oleh' => $this->whenLoaded('tanggapan'),
            'tgl_tanggapan' => $this->tgl_tanggapan,
            'tanggapan' => $this->tanggapan,
        ];
    }
}
