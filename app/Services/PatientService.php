<?php

namespace App\Services;

use App\Traits\BaseService;
use App\Models\Patient;

class PatientService
{
    use BaseService;

    protected $model;

    public function __construct(Patient $model)
    {
        $this->model = new Patient();
    }

    public function index($request)
    {
        try {
            $limit = $request->limit ?? 10;
            $search = $request->s;
            $hospital_id = $request->hospital_id;
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
                if($hospital_id) {
                    $data = $this->model->where('hospital_id', $hospital_id);
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
}