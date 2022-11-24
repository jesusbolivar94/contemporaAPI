<?php

namespace App\Http\Requests;

use App\Rules\UsersActivo;
use App\Rules\UsersGenero;
use Illuminate\Foundation\Http\FormRequest;

class UsersCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'email' => 'required|email:filter',
            'genero' => [ 'required', 'string', new UsersGenero ],
            'activo' => 'required|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'nombre.required' => 'Parametro nombre es obligatorio',
            'nombre.string' => 'Parametro nombre debe ser una cadena de texto',
            'email.required' => 'Parametro email debe es obligatorio',
            'email.email' => 'Parametro email debe ser un mail valido',
            'genero.required' => 'Parametro genero es obligatorio',
            'genero.string' => 'Parametro genero debe ser una cadena de texto',
            'activo.required' => 'Parametro activo es obligatorio',
            'activo.boolean' => 'Parametro activo debe ser un valor Boolean',
        ];
    }
}
