<?php

namespace Tests\Integration;

use App\Dogs\DogHttpConnector;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DogHttpConnectorTest extends TestCase
{

    private DogHttpConnector $testSubject;

    public function setUp(): void
    {
        parent::setUp();
        $this->testSubject = app(DogHttpConnector::class);
    }

    #[Test]
    public function test_it_returns_an_array_of_dogs(): void
    {
        $mockData = [
            [
                'id' => 1,
                'name' => 'Affenpinscher'
            ],
            [
                'id' => 2,
                'name' => 'Beagle'
            ]
        ];

        Http::fake([
            config('services.dog_api.url') => Http::response($mockData, Response::HTTP_OK)
        ]);

        $dogs = $this->testSubject->getAllDogs();

        $this->assertEquals($dogs, $mockData);
    }

    #[Test]
    public function test_it_returns_empty_array_if_response_is_null(){

        Http::fake([
            config('services.dog_api.url') => Http::response(null, Response::HTTP_OK)
        ]);

        $dogs = $this->testSubject->getAllDogs();

        $this->assertEquals([], $dogs);


    }

    #[Test]
    public function test_it_throws_an_exception_if_api_fails()
    {
        Http::fake([
            config('services.dog_api.url') => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR)
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Downstream API Error');

        $this->testSubject->getAllDogs();

    }

}
