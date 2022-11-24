<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersAllRequest;
use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersPatchRequest;
use App\Http\Requests\UsersPutRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class UsersController extends Controller
{
    public static array $status = [
        'true' => 'active',
        'false' => 'inactive'
    ];

    public static array $gender = [
        'hombre' => 'male',
        'mujer' => 'female'
    ];

    protected function parseUser( $user ): array
    {
        return [
            'id' => $user['id'],
            'nombre' => $user['name'],
            'email' => $user['email'],
            'genero' => array_flip( self::$gender )[ $user['gender'] ],
            'activo' => array_flip( self::$status )[ $user['status'] ],
        ];
    }

    public function all( UsersAllRequest $request, $page = null ) {

        $data = $request->safe();

        $requestUrl = $this->apiUrl . '/users';
        $queryParameters = [];

        if ( !is_null($page) ) {
            $queryParameters['page'] = $data['page'];
        }

        if ( $request->has('nombre') ) {
            $queryParameters['name'] = $data['nombre'];
        }

        if ( $request->has('email') ) {
            $queryParameters['email'] = $data['email'];
        }

        if ( $request->has('genero') ) {
            $queryParameters['gender'] = self::$gender[ $data['genero'] ];
        }

        if ( $request->has('activos') ) {
            $queryParameters['status'] = self::$status[ $data['activos'] ];
        }

        $request = Http::get( $requestUrl . '?' . Arr::query( $queryParameters ) );

        if ( $request->status() === 401 ) {
            return response()->json([
                'message' => 'Fallo autorizacion con token en API goREST',
                'details' => $request->json()
            ], 401);
        }

        if ( $request->failed() ) {
            return response()->json([
                'message' => 'goREST Request error',
                'details' => $request->json()
            ], 400);
        }

        $response = $request->json();

        $users = array_map( [ $this, 'parseUser' ], $response );

        if ( count( $users ) === 0 ) {
            return response()->json( $response, 404 );
        }

        return response()->json( $users );

    }

    public function byId( UsersAllRequest $request, $id ) {

        $data = $request->safe();

        // Debe usar el token de goRest para poder consultar los usuarios creados
        $request = Http::withToken( $this->apiToken )
            ->get( $this->apiUrl . '/users?id=' . $data['id'] );

        if ( $request->status() === 401 ) {
            return response()->json([
                'message' => 'Fallo autorizacion con token en API goREST',
                'details' => $request->json()
            ], 401);
        }

        if ( $request->failed() ) {
            return response()->json([
                'message' => 'goREST Request error',
                'details' => $request->json()
            ], 400);
        }

        $response = $request->json();

        $users = array_map( [ $this, 'parseUser' ], $response );

        if ( count( $users ) === 0 ) {
            return response()->json( $response, 404 );
        }

        return response()->json( $users[0] );
    }

    public function patch( UsersPatchRequest $request, $id ) {

        $data = $request->safe();

        $requestUrl = $this->apiUrl . '/users';
        $queryParameters = [];

        if ( $request->has('nombre') ) {
            $queryParameters['name'] = $data['nombre'];
        }

        if ( $request->has('email') ) {
            $queryParameters['email'] = $data['email'];
        }

        if ( $request->has('genero') ) {
            $queryParameters['gender'] = self::$gender[ $data['genero'] ];
        }

        if ( $request->has('activo') ) {
            $queryParameters['status'] = self::$status[ $data['activo'] ];
        }

        $request = Http::withToken( $this->apiToken )
            ->patch( $requestUrl . '/' . $data['id'] . '?' . Arr::query( $queryParameters ) );

        if ( $request->status() === 401 ) {
            return response()->json([
                'message' => 'Fallo autorizacion con token en API goREST',
                'details' => $request->json()
            ], 401);
        }

        if ( $request->failed() ) {
            return response()->json([
                'message' => 'goREST Request error',
                'details' => $request->json()
            ], 400);
        }

        $user = $request->json();

        return response()->json( $this->parseUser( $user ) );

    }

    public function put( UsersPutRequest $request, $id ) {

        $data = $request->safe();

        $request = Http::withToken( $this->apiToken )
            ->put(
                $this->apiUrl . '/users/' . $data['id'],
                [
                    'name' => $data['nombre'],
                    'email' => $data['email'],
                    'gender' => self::$gender[ $data['genero'] ],
                    'status' => self::$status[ json_encode( $data['activo'] ) ]
                ]
            );

        if ( $request->status() === 401 ) {
            return response()->json([
                'message' => 'Fallo autorizacion con token en API goREST',
                'details' => $request->json()
            ], 401);
        }

        if ( $request->status() === 422 ) {
            return response()->json([
                'message' => 'No se pudo actualizar el usuario',
                'details' => $request->json()
            ], 400);
        }

        // Cualquier otro código de respuesta HTTP
        if ( $request->failed() ) {
            return response()->json([
                'message' => 'goREST Request error',
                'details' => $request->json()
            ], 400);
        }

        $user = $request->json();

        return response()->json( $this->parseUser($user) );

    }

    public function create( UsersCreateRequest $request, ) {

        $data = $request->safe();

        $request = Http::withToken( $this->apiToken )
            ->post(
                $this->apiUrl . '/users',
                [
                    'name' => $data['nombre'],
                    'email' => $data['email'],
                    'gender' => self::$gender[ $data['genero'] ],
                    'status' => self::$status[ json_encode( $data['activo'] ) ]
                ]
            );

        if ( $request->status() === 401 ) {
            return response()->json([
                'message' => 'Fallo autorizacion con token en API goREST',
                'details' => $request->json()
            ], 401);
        }

        if ( $request->status() === 422 ) {
            return response()->json([
                'message' => 'No se pudo crear el usuario',
                'details' => $request->json()
            ], 400);
        }

        // Cualquier otro código de respuesta HTTP
        if ( $request->failed() ) {
            return response()->json([
                'message' => 'goREST Request error',
                'details' => $request->json()
            ], 400);
        }

        $user = $request->json();

        return response()->json( $this->parseUser($user), 201 );
    }
}
