<?php

namespace App\Services;

use App\Repositories\DepartmentRepository;
use App\Repositories\BranchRepository;
use App\Models\Department;

class DepartmentService
{
    protected DepartmentRepository $departmentRepository;
    protected BranchRepository $branchRepository;

    public function __construct(DepartmentRepository $departmentRepository, BranchRepository $branchRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->branchRepository = $branchRepository;
    }

  
    public function getCreateFormData()
    {
        return $this->branchRepository->getList();
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function getDepartment(int $id): ?Department
    {
        return $this->departmentRepository->findWithBranch($id); 
    }

    public function update(int $id, array $data): ?Department
    {
        return $this->departmentRepository->update($id, $data);
    }

    public function delete(int $id): ?Department
    {
        return $this->departmentRepository->delete($id);
    }
}