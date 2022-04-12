<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Model\Manager;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class AuthenticateWithJwt
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();

        // Unauthorized response if token not there
        if(!$token) 
            return response()->json([
                'error' => 'Token nao informado.'
            ], 401);

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), env('JWT_ALG')));
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Token informado esta expirado.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Um erro ocorreu ao decodificar o token.'
            ], 400);
        }

        $manager = new Manager->findByToken($credentials->sub);

        // Now let's put the manager in the request class so that you can grab it from there
        $request->auth = $manager;

        return $next($request);
    }
} 