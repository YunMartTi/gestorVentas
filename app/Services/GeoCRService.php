<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class GeoCRService
{
    protected $baseUrl = 'https://ubicaciones.paginasweb.cr';

    public function getProvincias()
    {
        return Http::timeout(30)->get("{$this->baseUrl}/provincias.json")->json();
    }

    public function getCantones($provinciaId)
    {
        return Http::timeout(10)->get("{$this->baseUrl}/provincia/{$provinciaId}/cantones.json")->json();
    }

    public function getDistritos($provinciaId, $cantonId)
    {
        return Http::timeout(10)->get("{$this->baseUrl}/provincias/{$provinciaId}/cantones/{$cantonId}/distritos.json")->json();
    }
}
