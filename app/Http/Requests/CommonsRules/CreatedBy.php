<?php

namespace App\Http\Requests\CommonsRules;

class CreatedBy
{
public static function Run($object)
{
    $object->merge([
        'created_by' => auth()->user()->id,
    ]);
}
}
