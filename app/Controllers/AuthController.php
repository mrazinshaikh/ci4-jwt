<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends BaseController
{
    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $credentials = [
            'email'    => $email,
            'password' => $password
        ];
        $userModal = new UsersModel();
        $user = $userModal->find(1);

        // JWT START
        $key = 'base64:oP5KyK/MjfMM+vbd6SQBhmQW/IjhBiLpO0DmOSoMS88=';
        $iat = time();
        $nbf = $iat + 20; // token can be used in after 20 seconds from generation time 
        $exp = $nbf + 20; // token can be used until 20 seconds from nbf (not before time)
        $payload = array(
            "iss" => "http://122.122.122.122:9110", // issuer (Server url which issue the token)
            "aud" => "http://122.122.122.122:9110", // audience (url of the client)
            "iat" => $iat, // issued at
            "nbf" => $nbf, // not before in seconds
            "exp" => $exp, // expire time in seconds
            "user" => $user // extra data to append with the token
        );

        $jwt = JWT::encode($payload, $key, 'HS256');

        // JWT END

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'User logged In successfully',
            'data' => [
                'token' => $jwt
            ]
        ];
        return json_encode($response);

        // Sample Response Start
        // {
        //     "status": 200,
        //     "error": false,
        //     "messages": "User logged In successfully",
        //     "data": {
        //       "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTIyLjEyMi4xMjIuMTIyOjkxMTAiLCJhdWQiOiJodHRwOi8vMTIyLjEyMi4xMjIuMTIyOjkxMTAiLCJpYXQiOjE2NTk4Njg3NzMsIm5iZiI6MTY1OTg2ODc5MywiZXhwIjoxNjU5ODY4ODEzLCJ1c2VyIjp7ImlkIjoiMSIsInVzZXJuYW1lIjoiU3lzdGVtIFVzZXIiLCJzdGF0dXMiOm51bGwsInN0YXR1c19tZXNzYWdlIjpudWxsLCJ1aWQiOm51bGwsImFjdGl2ZSI6IjEiLCJsYXN0X2FjdGl2ZSI6bnVsbCwiY3JlYXRlZF9hdCI6IjIwMjItMDgtMDcgMTU6MjA6MjYiLCJ1cGRhdGVkX2F0IjpudWxsLCJkZWxldGVkX2F0IjpudWxsfX0.9Sx6WGzXtPc0AbxfvVjvYyc7bWY8uhGfx3VUQIHCeE0"
        //     }
        // }
        // Sample Response End

    }

    public function test1()
    {
        $key = Services::getSecretKey();
        $authHeader = $this->request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();

        try {
            $token = explode(' ', $authHeader)[1];
            $decoded = JWT::decode($token, new Key($key, "HS256"));
            if ($decoded) {

                $response = [
                    'status' => 200,
                    'error' => false,
                    'messages' => 'User details',
                    'data' => [
                        'profile' => $decoded->user
                    ]
                ];
                return json_encode($response);
            }
        } catch (\Exception $ex) {

            $response = [
                'status' => 401,
                'error' => true,
                'messages' => 'Access denied',
                'data' => []
            ];
            return json_encode($response);
        }

        // Sample Response start
        // {
        //     "status": 200,
        //     "error": false,
        //     "messages": "User details",
        //     "data": {
        //       "profile": {
        //         "id": "1",
        //         "username": "System User",
        //         "status": null,
        //         "status_message": null,
        //         "uid": null,
        //         "active": "1",
        //         "last_active": null,
        //         "created_at": "2022-08-07 15:20:26",
        //         "updated_at": null,
        //         "deleted_at": null
        //       }
        //     }
        //   }
        // Sample Response end
    }
}
