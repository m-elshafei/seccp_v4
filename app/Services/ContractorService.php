<?php

namespace App\Services;

use App\Repositories\ContractorRepository;
use App\Models\Contractor;

class ContractorService
{
    protected ContractorRepository $contractorRepository;

    public function __construct(ContractorRepository $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }


    public function createContractor(array $data): Contractor
    {

        $contractor = $this->contractorRepository->create($data);
        return $contractor;
    }

    public function getContractor(int $id): ?Contractor
    {
        return $this->contractorRepository->find($id);
    }

    public function updateContractor(int $id, array $data): ?Contractor
    {

        $contractor = $this->getContractor($id);

        if (empty($contractor)) {
            return null;
        }

        $updatedContractor = $this->contractorRepository->update($contractor, $data);

        return $updatedContractor;
    }

    public function deleteContractor(int $id): bool
    {
        $isDeleted = $this->contractorRepository->delete($id);

        return $isDeleted;
    }
}