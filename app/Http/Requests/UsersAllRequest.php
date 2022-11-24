<?php

namespace App\Http\Requests;

use App\Rules\UsersActivo;
use App\Rules\UsersGenero;
use Illuminate\Foundation\Http\FormRequest;

class UsersAllRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'page' => 'nullable|numeric',
            'id' => 'nullable|numeric',
            'nombre' => 'nullable|string',
            'email' => 'nullable|string',
            'genero' => [ 'nullable', 'string', new UsersGenero ],
            'activos' => [ 'nullable', 'string', new UsersActivo ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'page.numeric' => 'Parametro page debe ser numerico',
            'id.numeric' => 'Parametro id debe ser numerico',
            'nombre.string' => 'Parametro nombre debe ser una cadena de texto',
            'email.string' => 'Parametro email debe ser una cadena de texto',
        ];
    }

    public function prepareForValidation() {

        $this->merge([
            'page' => $this->route('page'),
            'id' => $this->route('id')
        ]);

    }
}
