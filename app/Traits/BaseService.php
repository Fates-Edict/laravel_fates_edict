<?php

namespace App\Traits;

trait BaseService
{
    public function searchableColumns() {
        return $this->model->searchable ? $this->model->searchable : [];
    }

    public function initModel($id = null)
    {
        try {
            $data = $id ? $this->model->find($id) : $this->model;
            return $data;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function index($request)
    {
        try {
            $limit = $request->limit ?? 10;
            $search = $request->s;
            if($request->table) {
                $data = $this->model;
                if($search) {
                    $search = $request->s;
                    $columns = $this->searchableColumns();
                    $data = $this->model->where(function($query) use ($columns, $search) {
                        for($i = 0; $i < count($columns); $i++) {
                            if($i === 0) $query->where($columns[$i], 'LIKE', '%' . $search . '%');
                            else $query->orWhere($columns[$i], 'LIKE', '%' . $search . '%');
                        }
                    });
                }
                $data = $data->orderBy('id', 'DESC')->paginate($limit);
                $data->withPath('?table=true');
            } else {
                $data = $this->model;
                if($request->limit && $request->limit !== 0) $data = $data->limit($request->limit);
                $data = $data->get();
            }
            return $data;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function findById($request, $id = null)
    {
        try {
            $data = $this->initModel($id);
            return $data;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function store($request, $id = null)
    {
        try {
            $data = $this->initModel($id);
            $data->fill($request->all());
            $data->save();
            return $data;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function destroy($request, $id = null)
    {
        try {
            $result = 0;
            $result = $this->model->where('id', $id)->delete();
            return $result;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}