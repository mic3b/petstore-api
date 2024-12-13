<?php
namespace App\Services;

use App\Repositories\PetRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PetService
{
    protected $petRepository;

    public function __construct(PetRepository $petRepository)
    {
        $this->petRepository = $petRepository;
    }

    public function validatePetData(array $data)
    {
     
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'photoUrls' => 'required|array|min:1',
            'photoUrls.*' => 'url', 
            'status' => 'required|string|in:available,pending,sold',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

   

    public function getAvailablePets()
    {
        return $this->petRepository->getAvailablePets();
    }

    public function addPet(array $data)
    {
        $this->validatePetData($data);

        return $this->petRepository->addPet($data);
    }

    public function updatePet( array $data)
    {
        $this->validatePetData($data);

        return $this->petRepository->updatePet( $data);
    }

    public function deletePet($petId)
    {
        return $this->petRepository->deletePet($petId);
    }


public function getPetById($petId)
{
    $pets = $this->petRepository->getAvailablePets();
    return collect($pets)->firstWhere('id', $petId);
}
}