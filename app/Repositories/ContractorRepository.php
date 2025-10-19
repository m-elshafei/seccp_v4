<?php

namespace App\Repositories;

use App\Models\Contractor;

class ContractorRepository
{
    public function create(array $data): Contractor
    {
        return Contractor::create($data);
    }

    public function find(int $id): ?Contractor
    {
        return Contractor::find($id);
    }

    public function update(Contractor $contractor, array $data): ?Contractor
    {
        $contractor->fill($data);
        $contractor->save();

        return $contractor;
    }

    public function delete(int $id): bool
    {
        $contractor = $this->find($id);

        if ($contractor) {
            return $contractor->delete();
        }

        return false;
    }

}