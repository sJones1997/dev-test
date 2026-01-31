<?php

namespace App\Dogs;

readonly class Dog
{
    public function __construct(
        public int             $id,
        public string $name,
        public string $lifeSpan,
        public array  $temperament,
        public string $description,
        public string $history,
        public string $weight,
        public string $height,
        public string $image
    ){}

    public static function fromApi($data): self
    {
        return new self(
            id:             $data['id'],
            name:           $data['name'],
            lifeSpan:       $data['life_span'] ?? '',
            temperament:    explode(',', $data['temperament'] ?? ''),
            description:    $data['description'] ?? '',
            history:        $data['history'] ?? '',
            weight:         $data['weight']['metric'] ?? '',
            height:         $data['weight']['metric'] ?? '',
            image:          $data['image']['url'] ?? ''
        );
    }
}
