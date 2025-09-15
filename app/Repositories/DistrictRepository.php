<?php

namespace App\Repositories;

use App\Models\District;
use App\Models\City;

class DistrictRepository
{

    protected $model;

    public function __construct(District $model)
    {
        $this->model = $model;
    }


    public function getCities()
    {
        return City::pluck('name', 'id');
    }

    public function create($input)
    {
        return $this->model->create($input);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function delete($district)
    {
        return $district->delete();
    }

    public function update($district, $input)
    {
        return $district->update($input);
    }

}

