<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Services\PatientService;

class PatientController extends Controller
{
    protected $service;

    public function __construct(PatientService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->service->index($request);
            return H_apiSuccess($data);
        } catch(Exception $e) {
            return H_api500($e->getMessage());
        }
    }

    public function findById(Request $request, $id = null)
    {
        try {
            $data = $this->service->findById($request, $id);
            if(!$data) return H_api404();
            return H_apiSuccess($data);
        } catch(Exception $e) {
            return H_api500($e->getMessage());
        }
    }

    public function store(Request $request, $id = null)
    {
        try {
            $model = $this->service->initModel($id);
            $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'hospital_id' => 'required|integer',
                'address' => 'required',
                'phone' => 'required'
            ],
            [
                'hospital_id.required' => 'Hospital is required',
                'hospital_id.integer' => 'Hospital is required',
            ]);
            
            if($validator->fails()) return H_api400($validator->errors());
            
            $data = $this->service->store($request, $id);
            $msg = H_responseMsg($id ? 'u' : 'c');

            return H_apiSuccess($data, 201, $msg);
        } catch(Exception $e) {
            return H_api500($e->getMessage());
        }
    }

    public function destroy(Request $request, $id = null)
    {
        try {
            $data = $this->service->destroy($request, $id);
            $msg = H_responseMsg('d');
            return H_apiSuccess($data, 200, $msg);
        } catch(Exception $e) {
            return H_api500($e->getMessage());
        }
    }
}
