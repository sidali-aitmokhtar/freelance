<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * Create a new class instance.
     */
    private Model $model;
    public function __construct(Model $model)
    {
        $this->model=$model;
    }
    public function all(){
        return $this->model->all();
    }
    public function find($id){
        return $this->model->find($id);
    }
    Public function create($data){
        return $this->model->create($data);
    }
    public function query(){
        return $this->model->newQuery();
    }
    public function update($data,$id){
        $model = $this->model->find($id);
        if (!$model) {
            return false;
        }
        $model->update($data);
        return $model->fresh();
    }
    public function delete($id){
        $deleted=$this->model->destroy($id);
        return $deleted>0;
    }
}
