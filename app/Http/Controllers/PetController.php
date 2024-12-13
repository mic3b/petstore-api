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
            // echo '<pre>';
            // foreach ($pets as $pet) {
            //     echo $pet['name'] . "\n";
            // }
            // echo '</pre>';
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
            // $petData = $request->validate([
            //     'name' => 'required|string|max:255',
            //     'category' => 'required',
            //     'category.id' => 'required|integer',
            //     'category.name' => 'required|string|max:255',
            //     'photoUrls' => 'required|array|min:1',
            //     'photoUrls.*' => 'required|url',
            //     'tags' => 'optional|array|min:1',
            //     'tags.*.id' => 'optional|integer',
            //     'tags.*.name' => 'required|string|max:255',
            //     'status' => 'required|string|in:available,pending,sold',
            // ]);
            $data = array_merge([
                'id' => 0,
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

            echo '<pre>';
            print_r($data);
            echo '</pre>';

            $petData = $request->all();

            $pet = $this->petService->addPet($petData);
            return redirect()->route('pets.index')->with('success', 'Zwierzę dodane pomyślnie');
        } catch (\Illuminate\Validation\ValidationException $e) {
           
            // return back()->withErrors($e->errors())->withInput();
            echo '<pre>';
            print_r($e->errors());
            echo '</pre>';
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add pet: ' . $e->getMessage()], 500);
        }
    }

    public function edit($petId)
    {
        try {
            $pet = $this->petService->getAvailablePets();
            $pet = collect($pet)->firstWhere('id', $petId);

            return view('pets.edit', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Zwierzę nie zostało znalezione');
        }
    }

    public function update(Request $request, $petId)
    {
        try {
            $petData = $request->validate([
                'name' => 'required|string|max:255',
                'photoUrls' => 'required|array|min:1',
                'photoUrls.*' => 'url',
                'status' => 'required|string|in:available,pending,sold',
            ]);

         

            $this->petService->updatePet($petId, $petData);
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało zaktualizowane');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
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