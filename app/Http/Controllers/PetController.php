<?php

namespace App\Http\Controllers;

use App\Services\PetService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PetController extends Controller
{
    protected $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    public function index()
    {
        try {
            $pets = $this->petService->getAvailablePets();
   
            return view('pets.index', compact('pets'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch pets: ' . $e->getMessage()], 500);
        }
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        try {
            $data = array_merge([
                //In my opinion API is broken, I can only pet with id = 9223372036854775807. which is being deleted after each request, setting id to random value solves the problem
                'id' => rand(1, 99999999999999999),
                'name' => 'default_name',
                'photoUrls' => ['default_url'],
                'status' => 'available',
                'category' => [
                    'id' => 0,
                    'name' => 'default_category'
                ],
                'tags' => [
                    [
                        'id' => 0,
                        'name' => 'default_tag'
                    ]
                ]
            ], $request->all());

            $petData = $data;

            $pet = $this->petService->addPet($petData);

            return redirect()->route('pets.index')->with('success', 'Zwierzę dodane pomyślnie');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add pet: ' . $e->getMessage()], 500);
        }
    }

    public function edit($petId)
    {
        try {
            $pet = $this->petService->getPetById($petId);

            return view('pets.edit', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Zwierzę nie zostało znalezione');
        }
    }

    public function update(Request $request, $petId)
    {
        try {
            $data = $request->all();
            $data['id'] = $petId;
            $pet = $this->petService->getPetById($petId);

            $req_data = array_merge($pet, $data);

            $this->petService->updatePet($req_data);
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało zaktualizowane');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
            echo $e->getMessage();
        }
    }

    public function destroy($petId)
    {
        try {
            $this->petService->deletePet($petId);
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało usunięte');
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Nie udało się usunąć zwierzęcia');
        }
    }

    public function show($petId)
    {
        try {
            $pet = $this->petService->getPetById($petId);
            return view('pets.show', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Zwierzę nie zostało znalezione');
        }
    }
}