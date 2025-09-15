<?php

namespace App\Repositories;

use App\Models\City;


class CityRepository
{

    protected $model;
    public function __construct(City $model)
    {
        $this->model = $model;
    }
    public function getCities()
    {
        return $this->model;
    }

    public function create($input)
    {
        return $this->model->create($input);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function delete($city)
    {
        return $city->delete();
    }

    public function update($city, $input)
    {
        return $city->update($input);
    }
}
