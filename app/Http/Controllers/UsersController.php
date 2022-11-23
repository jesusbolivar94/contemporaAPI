<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function all( Request $request, $page = null ) {

        $request->merge( [ 'page' => $request->route('page') ] );

        $validator = Validator::make($request->all(), [
            'page' => 'nullable|numeric'
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'message' => 'Fail data validation',
                'details' => $validator->messages()->toArray()
            ], 400);
        }

        $apiUrl = env('GO_REST_API_URL');

        $requestUrl = ( !is_null($page) )
            ? $apiUrl . '/users?page=' . $page
            : $apiUrl . '/users';

        $request = Http::get( $requestUrl );

        if ( $request->failed() ) {
            return response()->json([
                'message' => 'goREST Request error',
            ]);
        }

        $response = $request->json();

        $users = [];
        foreach ( $response as $user ) {
            $users[] = [
                'id' => $user['id'],
                'nombre' => $user['name'],
                'email' => $user['email'],
                'genero' => $user['gender'],
                'activo' => $user['status'] === 'active',
            ];
        }

        if ( count( $users ) === 0 ) {
            return response()->json( $response, 404 );
        }

        return response()->json( $users );
    }
}
