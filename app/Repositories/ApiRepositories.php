<?php

namespace App\Repositories;

use App\Repositories\contracts\ApiContracts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\User;
use Exception;
use Auth;

class ApiRepositories implements ApiContracts
{

	public function get(){
        try {            
            return Auth::user();
            } catch (Exception $exception) {
            throw $exception;
        }
	}

    public function store($data){
        try {
            return  User::create([
                    'name' => $data['name'],
                    'email'=> $data['email'],
                    'password'=>Hash::make($data['password'])
            ]);
            } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function login($data){
        try {

            $user = user::where('email',$data['email'])->first();
                if (!empty($user)) {
                    if (Hash::check($data['password'],$user->password)) {
                        return $user->createToken($user->name.'-AuthToken')->plainTextToken;
                    }
                    return false;
                }
            } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function destroy(){
        try {
                $user = Auth::user();
                return $user->currentAccessToken()->delete();
            } catch(Exception $e){
             return $e->getMessage();
        }
    }
}

