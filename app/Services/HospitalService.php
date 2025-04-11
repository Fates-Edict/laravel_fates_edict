<?php

namespace App\Services;

use App\Traits\BaseService;
use App\Models\Hospital;
use App\Models\Patient;

class HospitalService
{
    use BaseService;

    protected $model;

    public function __construct(Hospital $model)
    {
        $this->model = new Hospital();
    }

    public function destroy($request, $id = null)
    {
        try {
            $result = 0;
            $result = $this->model->where('id', $id)->delete();
            Patient::where('hospital_id', $id)->delete();
            return $result;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}