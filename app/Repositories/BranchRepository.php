<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Models\City;

class BranchRepository
{
    /**
     * Get all cities with their districts
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCities()
    {
        return City::pluck('name', 'id');
    }

    public function find($id)
    {
        return Branch::findOrFail($id);
    }

    public function create($data)
    {
        return Branch::create($data);
    }

    public function update($id, $data)
    {
        return Branch::find($id)->update($data);
    }

    public function delete($id)
    {
        return Branch::destroy($id);
    }

    public function getAll()
    {
        return Branch::all();
    }

    public function getList()
    {
        return Branch::pluck('name', 'id');
    }
}
