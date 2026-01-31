<?php

namespace Tests\Unit;

use App\Dogs\Dog;
use App\Dogs\DogHttpConnector;
use App\Dogs\DogService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class DogServiceTest extends TestCase
{
    private DogService $testSubject;
    private MockObject $mockDogHttpConnector;
    private static array $MOCK_DATA = [['id' => 1,'name' => 'Affenpinscher']];

    public function setUp(): void
    {
        parent::setUp();

        $this->mockDogHttpConnector = $this->createMock(DogHttpConnector::class);
        $this->app->instance(DogHttpConnector::class, $this->mockDogHttpConnector);
        $this->testSubject = app(DogService::class);
    }

    #[Test]
    public function test_get_all_dogs_returns_collection_of_dog_dtos()
    {
        $this->mockDogHttpConnector
            ->method('fetchAllDogs')
            ->willReturn(self::$MOCK_DATA);

        $dogs = $this->testSubject->getAllDogs();

        $this->assertInstanceOf(Collection::class, $dogs);
        $this->assertInstanceOf(Dog::class, $dogs->first());
        $this->assertCount(1, $dogs);
    }

    #[Test]
    public function test_gets_results_from_cache()
    {
        Cache::forget('c_dog_index');


        $this->mockDogHttpConnector
            ->method('fetchAllDogs')
            ->willReturn(self::$MOCK_DATA);

        $this->testSubject->getAllDogs();

        $this->assertTrue(Cache::has('c_dog_index'));
    }

    #[Test]
    public function test_exception_is_thrown_when_rate_limit_is_reached()
    {
        Cache::forget('c_dog_index');

        RateLimiter::shouldReceive('attempt')
            ->once()
            ->andReturn(false);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Rate Limit Exceeded');

        $this->testSubject->getAllDogs();

    }

}
