<?php

namespace App\Services;

abstract class BaseService{

    protected $repo;
    public function store($validated, $id = null)
    {
        $prepared = $validated;
        if(method_exists($this, 'prepareRequest')){
            $prepared = $this->prepareRequest($validated);
        }

        return $id ? $this->repo->store($prepared) : $this->repo->update($prepared, $id);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    public function prepareRequest($validated)
    {
        return is_array($validated) ? $validated : $validated->all();
    }
}
