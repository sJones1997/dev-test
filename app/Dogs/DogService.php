<?php

namespace App\Dogs;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

readonly class DogService
{
    public function __construct(private DogHttpConnector $httpConnector){}

    public function getAllDogs(): Collection
    {
        $results = Cache::remember(
            key: 'c_dog_index',
            ttl: now()->addMinutes(10),
            callback: function() {

                $results = RateLimiter::attempt(
                    key: 'rl_dog_index',
                    maxAttempts: 10,
                    callback: fn() => $this->httpConnector->fetchAllDogs(),
                    decaySeconds: 60
                );

                if(!$results) {
                    throw new \RuntimeException('Rate Limit Exceeded');
                }

                return $results;

            }
        );

        return collect($results)->map(fn(array $data) => Dog::fromApi($data));
    }
}
