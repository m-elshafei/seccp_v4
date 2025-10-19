<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository
{
  
    public function findWithBranch(int $id): ?Department
    {
        return Department::with('branch')->find($id);
    }

    public function find(int $id): ?Department  
    {
        return Department::find($id);
    }

    public function update(int $id, array $data): ?Department
    {
        return Department::find($id)->update($data);
    }

    public function delete(int $id): ?Department
    {
        return Department::find($id)->delete();
    }

}