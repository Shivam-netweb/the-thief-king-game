<?php

namespace App\Repositories;

use Throwable;
use Illuminate\Support\Str;

class BaseRepository{

    protected $model;

    public function getModelName()
    {
        $ClassNameWithNameSpace = explode('\\',get_class($this->model));
        return Str::singular(strtolower(end($ClassNameWithNameSpace)));
    }
    public function store($prepared)
    {
        try{
            if($this->model->create($prepared)) return $this->message(__('responses.insert', ['model' => $this->getModelName()]));
            throw new \RuntimeException('Something Went wrong with the server');
        }catch(Throwable $th){
            return $this->message(__('responses.error'), 500, 'failed', $th->getMessage());
        }
    }

    public function update($prepared, $id)
    {
        try{
            if($this->model->where('id',$id)->update($prepared)) return $this->message(__('responses.update', ['model' => $this->getModelName()]));
            throw new \RuntimeException('Something Went wrong with the server');
        }catch(Throwable $th){
            return $this->message(__('responses.error'), 500, 'failed', $th->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            if($this->model->where('id',$id)->delete()) return $this->message(__('responses.delete', ['model' => $this->getModelName()]));
            throw new \RuntimeException('Something Went wrong with the server');
        }catch(Throwable $th){
            return $this->message(__('responses.error'), 500, 'failed', $th->getMessage());
        }
    }

    public function message($message, $statusCode = 200, $statusText = 'success', $error = null,$addOn = [])
    {
        return response(array_merge([
            'message' => $message,
            'status' => $statusCode,
            'type' => $statusText
        ], ($error ? ['error' => $error] : []), ($addOn ? $addOn : [])), $statusCode);
    }
}
