<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PengaduanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'id_user' => $this->id_user,
            'oleh' => $this->whenLoaded('pengaduan'),
            'nama_pengaduan' => $this->nama_pengaduan,
            'isi_pengaduan' => $this->isi_pengaduan,
            'foto' => $this->image,
            'status' => $this->status
        ];
    }
}
