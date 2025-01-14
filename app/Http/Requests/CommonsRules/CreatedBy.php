<?php

namespace App\Http\Requests\CommonsRules;

/**
 * Cette classe centralise la personne qui est actuellement authentifiée.
 * Elle sert principalement à associer l'utilisateur actuel à tout objet nouvellement créé.
 *
 * Note: C'est une classe statique.
 */
class CreatedBy
{
    /**
     * Cette méthode associe l'id de l'utilisateur actuellement authentifié à l'objet passé en paramètre.
     *
     * @param  object $object L'objet à associer à l'utilisateur actuel.
     * @return void
     */
    public static function Run($object)
    {

        $object->merge([
            'created_by' => auth()->user()->id,
        ]);
    }
}
