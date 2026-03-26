<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TesisResource extends JsonResource
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
        'titulo' => $this->titulo,
        'resumen' => $this->resumen,
        'anio' => $this->anio,
        'pdfUrl' => $this->pdf_path ? asset('storage/' . $this->pdf_path) : null,
        'status' => $this->status,
        'carrera' => new CarreraResource($this->whenLoaded('carrera')),
        'autores' => PersonaResource::collection($this->whenLoaded('autores')),
        'tutor' => new PersonaResource($this->whenLoaded('tutor')),
    ];
    }
}
