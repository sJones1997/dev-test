<?php

namespace App\Http\Controllers;

use App\Dogs\DogService;
use Illuminate\View\View;

class DogsController extends Controller
{

    public function __construct(private DogService $service){}

    public function index(): View
    {
        try {
            $dogs = $this->service->getAllDogs();
            return view('dogs.index', compact('dogs'));
        } catch (\Exception $e){
            return view('dogs.index', ['error' => $e->getMessage(), 'dogs' => []]);
        }
    }
}
