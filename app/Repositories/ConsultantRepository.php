<?php

namespace App\Repositories;

use App\Models\Consultant;

class ConsultantRepository
{
    public function find(int $id): ?Consultant
    {
        return Consultant::find($id);
    }

    public function create(array $data)
    {
        return Consultant::create($data);
    }

    public function update(int $id, array $data): ?Consultant
    {
        $consultant = $this->find($id); 

        if ($consultant) {
            $consultant->fill($data);
            $consultant->save();
        }

        return $consultant;
    }


    public function delete(int $id): bool
    {
        $consultant = $this->find($id);

        if ($consultant) {
            return $consultant->delete();
        }

        return false;
    }

}