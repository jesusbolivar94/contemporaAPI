<?php

namespace App\Rules;

use App\Http\Controllers\UsersController;
use Illuminate\Contracts\Validation\InvokableRule;

class UsersActivo implements InvokableRule
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
        if ( !in_array( $value, array_flip( UsersController::$status ) ) ) {
            $fail('Valor de parametro activos no soportado');
        }
    }
}
