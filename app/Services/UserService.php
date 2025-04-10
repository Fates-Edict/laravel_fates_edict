<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function authenticate($request)
    {
        try {
            $response = (object) [];
            $find = User::where('username', $request->username)->first();
            if(!$find) {
                $response->status = 400;
                $response->errors = [
                    'username' => ['Username does not exist.']
                ];
            } else {
                $comparePassword = Hash::check($request->password, $find->password);
                if(!$comparePassword) {
                    $response->status = 400;
                    $response->errors = [ 'password' => ['Password does not match.'] ];
                } else {
                    $response->status = 200;
                    $response->token  = $find->createToken('Personal Access Token')->plainTextToken;
                }
            }

            return $response;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function me($request)
    {
        try {
            $user = auth()->user();
            $data = User::where('id', $user->id)->first();
            return $data;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}