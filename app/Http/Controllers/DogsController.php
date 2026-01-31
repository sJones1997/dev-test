<?php

namespace App\Http\Controllers;

use App\Dogs\Dog;
use App\Dogs\DogService;
use App\Http\Requests\ShowDogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DogsController extends Controller
{

    public function __construct(private DogService $service){}

    public function index(Request $request): View
    {
        try {
            $dogs = $this->service->getAllDogs();

            if($searchTerm = $request->get('search')){
                $dogs = $dogs->filter(fn(Dog $dog) => str_contains(strtolower($dog->name), strtolower($searchTerm)));
            }

            return view('dogs.index', compact(['dogs']));
        } catch (\Exception $e){

            Log::error('Dog index request failed', [
                'message'   => $e->getMessage(),
                'method' => 'DogsController@index'
            ]);

            return view('dogs.index', ['error' => 'Looks like something has gone wrong on our side, we\'ll fix it as soon as possible', 'dogs' => []]);
        }
    }

    public function show(int $dogId): View
    {
        try {

            $dog = $this->service->getDogById($dogId);
            return view('dogs.show',compact('dog'));

        } catch (NotFoundHttpException $e){

            return view('dogs.show', ['error' => 'We were unable to find the dog you were looking for.', 'dogs' => []]);

        } catch (\Exception $e){

            Log::error('Dog show request failed', [
                'message'   => $e->getMessage(),
                'method' => 'DogsController@show'
            ]);

            return view('dogs.show', ['error' => 'Looks like something has gone wrong on our side, we\'ll fix it as soon as possible', 'dogs' => []]);
        }

    }

}
