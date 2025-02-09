<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Gère l'accès à la route en vérifiant si l'utilisateur est authentifié.
     *
     * Ce middleware vérifie si l'utilisateur est connecté. Si l'utilisateur n'est pas authentifié,
     * il est redirigé vers la page de connexion. Si l'utilisateur est authentifié, la requête est
     * passée à la prochaine étape du traitement de la requête.
     *
     * @param \Illuminate\Http\Request $request La requête HTTP entrante.
     * @param \Closure $next La prochaine action ou middleware dans le pipeline.
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *         La réponse redirigeant l'utilisateur vers la page de connexion si non authentifié,
     *         ou la réponse de la prochaine étape du pipeline si l'utilisateur est authentifié.
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!auth()->check()) {
            return redirect('/login');
        }
        return $next($request);
    }
}
