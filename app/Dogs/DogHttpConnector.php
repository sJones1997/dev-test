<?php

namespace App\Dogs;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DogHttpConnector
{
    private string $API_DOG;
    private string $API_DOG_URL;

    public function __construct()
    {
        $this->API_DOG = config('services.dog_api.key');
        $this->API_DOG_URL = config('services.dog_api.url');
    }

    public function fetchAllDogs(): array {

        $response = Http::withHeaders(['x-api-key' => $this->API_DOG])
            ->get( url: $this->API_DOG_URL);

        if($response->failed()){

            Log::error('Dog API request failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
                'headers' => $response->headers(),
            ]);

            throw new \RuntimeException('Downstream API Error');
        }

        return $response->json() ?? [];

    }

}
