<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Manager;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Create a new token.
     * 
     * @param  \App\Manager   $manager
     * @return string
     */
    protected function jwtEncode(Manager $manager) {
        $payload = [
            'sub' => $manager->id, // Subject of the token
            'name' => $manager->name, // Name
            'level' => $manager->level, // Level
            'email' => $manager->email, // Email
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + getenv('JWT_EXP') // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'), env('JWT_ALG'));
    }

    /**
     * Authenticate a manager and return the token if the provided credentials are correct.
     * 
     * @param  \App\Manager   $manager 
     * @return mixed
     */
    public function authenticate(Manager $manager) {
        $validator = Validator::make($this->request->all(), [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'error' => $validator->messages()
            ], 400);
        }

        // Find the manager by email
        $manager = $manager->findByEmail($this->request->input('email'));

        if (!$manager) {
            return response()->json([
                'error' => 'O Email nao existe.'
            ], 400);
        }

        // Verify the password
        if (!Hash::check($this->request->input('password'), $manager->password)) {
            return response()->json([
                'error' => 'Senha incorreta.'
            ], 400);
        }

        // Update token
        $token = $this->jwtEncode($manager);

        $manager->updateToken($token);

        // Finally return the token
        return response()->json([
            'token' => $token
        ], 200);
    }
}
