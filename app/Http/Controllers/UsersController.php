<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    protected static array $status = [
        'true' => 'active',
        'false' => 'inactive'
    ];

    protected static array $gender = [
        'hombre' => 'male',
        'mujer' => 'female'
    ];

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

        $requestUrl = $apiUrl . '/users';
        $queryParameters = [];

        if ( !is_null($page) ) {
            $queryParameters['page'] = $page;
        }

        if ( $request->has('nombre') ) {
            $queryParameters['name'] = $request->query('nombre');
        }

        if ( $request->has('email') ) {
            $queryParameters['email'] = $request->query('email');
        }

        if ( $request->has('genero') ) {
            if ( !in_array( $request->query('genero'), array_flip( self::$gender ) ) ) {
                return response()->json([
                    'message' => 'Valor de genero no soportado',
                ], 400);
            }

            $queryParameters['gender'] = self::$gender[ $request->query('genero') ];
        }

        if ( $request->has('activos') ) {
            $queryParameters['status'] = self::$status[ $request->query('activos') ];
        }

        $request = Http::get( $requestUrl . '?' . Arr::query( $queryParameters ) );

        if ( $request->failed() ) {
            return response()->json([
                'message' => 'goREST Request error',
                'details' => $request->json()
            ], 400);
        }

        $response = $request->json();

        $users = [];
        foreach ( $response as $user ) {
            $users[] = [
                'id' => $user['id'],
                'nombre' => $user['name'],
                'email' => $user['email'],
                'genero' => array_flip( self::$gender )[ $user['gender'] ],
                'activo' => $user['status'] === 'active',
            ];
        }

        if ( count( $users ) === 0 ) {
            return response()->json( $response, 404 );
        }

        return response()->json( $users );

    }
}
