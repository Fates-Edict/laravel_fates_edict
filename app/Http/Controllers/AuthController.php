<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\UserService;

class AuthController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function authenticate(Request $request)
    {
        try {
            $response = (object) [];
            $validator = Validator::make($request->all(),
            [
                'username' => 'required',
                'password' => 'required'
            ]);
            
            if($validator->fails()) return H_api400($validator->errors());

            $data = $this->service->authenticate($request);

            if($data->status == 400) return H_api400($data->errors);

            return H_apiSuccess($data->token, 201, 'Succeed');
        } catch(Exception $e) {
            return H_api500($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return H_apiSuccess(null, 200, 'Sign out success');
        } catch(Exception $e) {
            return H_api500($e->getMessage());
        }
    }

    public function me(Request $request)
    {
        try {
            $data = $this->service->me($request);
            if(!$data) return H_api404('User');
            return H_apiSuccess($data);
        } catch(Exception $e) {
            return H_api500($e->getMessage());
        }
    }
}
