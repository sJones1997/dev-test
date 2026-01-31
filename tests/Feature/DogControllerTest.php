<?php

namespace Tests\Feature;

use App\Dogs\Dog;
use App\Dogs\DogService;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class DogControllerTest extends TestCase
{
    private static array $MOCK_DATA = [['id' => 1,'name' => 'Affenpinscher'], ['id' => 2, 'name' => 'American Bully'], ['id' => 3, 'name' => 'Boerboel']];
    private MockObject $mockDogService;
    public function setUp(): void
    {
        parent::setUp();

        $this->mockDogService = $this->createMock(DogService::class);
        $this->app->instance(DogService::class, $this->mockDogService);
    }

    #[Test]
    public function test_index_returns_dogs()
    {
        $dogs = collect(self::$MOCK_DATA)->map(fn($dog) => Dog::fromApi($dog));

        $this->mockDogService
            ->method('getAllDogs')
            ->willReturn($dogs);

        $this->get(route('dogs.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('dogs.index')
            ->assertViewHas('dogs', function($viewDogs) use ($dogs) {
                return count($viewDogs) === count($dogs);
            });

    }

    #[Test]
    public function test_index_handles_exception()
    {
        $this->mockDogService
            ->method('getAllDogs')
            ->willThrowException(new \RuntimeException('Rate Limit Exceeded'));

        $this->get(route('dogs.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('dogs.index')
            ->assertViewHas('error', 'Looks like something has gone wrong on our side, we\'ll fix it as soon as possible');


    }

    #[Test]
    public function test_index_can_filter_search()
    {
        $dogs = collect(self::$MOCK_DATA)->map(fn($dog) => Dog::fromApi($dog));

        $this->mockDogService
            ->method('getAllDogs')
            ->willReturn($dogs);

        $this->get(route('dogs.index', ['search' => 'American']))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('dogs.index')
            ->assertViewHas('dogs', function($viewDogs) use ($dogs) {
                return count($viewDogs) === 1;
            });

    }

    #[Test]
    public function test_show_returns_a_dog()
    {
        $dog = Dog::fromApi(self::$MOCK_DATA[0]);

        $this->mockDogService
            ->method('getDogById')
            ->willReturn($dog);

        $this->get(route('dogs.show', ['dogId' => $dog->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('dogs.show')
            ->assertViewHas('dog', function ($viewDog) use ($dog) {
                return $viewDog->id === $dog->id;
            });

    }

    #[Test]
    public function test_throws_exception_when_dog_is_not_found()
    {
        $dog = Dog::fromApi(self::$MOCK_DATA[0]);

        $this->mockDogService
            ->method('getDogById')
            ->willThrowException(new NotFoundHttpException('"Dog with id 1000 not found"'));

        $this->get(route('dogs.show', ['dogId' => $dog->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('dogs.show')
            ->assertViewHas('error', 'We were unable to find the dog you were looking for.');

    }


}
