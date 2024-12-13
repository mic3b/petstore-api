<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PetRepository
{
    private $baseUrl = 'https://petstore.swagger.io/v2/pet';

    public function getAvailablePets()
    {
        $cacheKey = 'available_pets';
    
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/findByStatus", ['status' => 'available']);
    
            if ($response->failed()) {
                throw new \Exception('Failed to fetch data from the API.');
            }
    
            Cache::put($cacheKey, $response->json(), now()->addMinutes(60));
    
            return $response->json();
            
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            if ($this->isCacheAvailable($cacheKey)) {
                return Cache::get($cacheKey);
            }
    
            throw new \Exception('Request timed out, and no cached data is available.');
        }
    }

    public function addPet(array $data)
    {
        $response = Http::timeout(5)->post("{$this->baseUrl}", $data);

        if ($response->failed()) {
            throw new \Exception('Failed to add pet to the store.');
        }

        return $response->json();
    }

    public function updatePet(array $data)
    {
        $response = Http::timeout(5)->put("{$this->baseUrl}/", $data);

        echo $response->status();

        if ($response->failed()) {
            throw new \Exception('Failed to update pet.');
        }

        return $response->json();
    }

    public function deletePet($petId)
    {
        $response = Http::timeout(5)->delete("{$this->baseUrl}/{$petId}");

        if ($response->failed()) {
            throw new \Exception('Failed to delete pet.');
        }

        return $response->json();
    }


    protected function isCacheAvailable($cacheKey)
    {
        return Cache::has($cacheKey);
    }
}

