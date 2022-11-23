<?php

namespace App\Rules;

use App\Http\Controllers\UsersController;
use Illuminate\Contracts\Validation\InvokableRule;

class UsersGenero implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if ( !in_array( $value, array_flip( UsersController::$gender ) ) ) {
            $fail('Valor de parametro genero no soportado');
        }
    }
}
