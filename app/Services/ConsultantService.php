<?php

namespace App\Services;

use App\Repositories\ConsultantRepository;
use App\Models\Consultant;

class ConsultantService
{
    protected ConsultantRepository $consultantRepository;

    public function __construct(ConsultantRepository $consultantRepository)
    {
        $this->consultantRepository = $consultantRepository;
    }

    public function createConsultant(array $data): Consultant
    {
        $consultant = $this->consultantRepository->create($data);

        return $consultant;
    }

    public function getConsultant(int $id): ?Consultant
    {
        return $this->consultantRepository->find($id);
    }

    public function updateConsultant(int $id, array $data): ?Consultant
    {

        $consultant = $this->consultantRepository->update($id, $data);

        return $consultant;
    }

    public function deleteConsultant(int $id): bool
    {
        $isDeleted = $this->consultantRepository->delete($id);

        return $isDeleted;
    }
}