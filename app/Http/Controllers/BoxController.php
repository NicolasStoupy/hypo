<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IApplicationContext;
use Illuminate\Http\Request;

class BoxController extends Controller
{


    public function __construct(protected IApplicationContext $context)
    {

    }

    /**
     * Affiche la liste de toutes les boxs de nettoyage.
     *
     * Cette méthode récupère toutes les boxs depuis le service de nettoyage et les passe à la vue 'box.index'.
     *
     * @return \Illuminate\View\View La vue affichant la liste des boxs.
     */
    public function index()
    {
        $boxs = $this->context->cleaning()->getAll();

        return view('box.index', compact('boxs'));
    }

    /**
     * Affiche la page d'assignation des poneys aux boxs.
     *
     * Cette méthode récupère tous les poneys et tous les boxs, puis les passe à la vue 'box.assign_poney'
     * pour permettre l'assignation des poneys aux boxs.
     *
     * @return \Illuminate\View\View La vue pour l'assignation des poneys.
     */
    public function assign_poney()
    {
        $poneys = $this->context->poney()->getAll();
        $boxs = $this->context->cleaning()->getAll();

        return view('box.assign_poney', compact('boxs', 'poneys'));
    }

    /**
     * Assigne un poney à un box spécifique.
     *
     * Cette méthode récupère l'ID du poney à partir de la requête et assigne ce poney au box
     * correspondant à l'ID passé en paramètre. Un message de succès est ensuite renvoyé à l'utilisateur.
     *
     * @param \Illuminate\Http\Request $request La requête contenant l'ID du poney.
     * @param int $id L'ID du box auquel le poney doit être assigné.
     *
     * @return \Illuminate\Http\RedirectResponse La redirection vers la page précédente avec un message de succès.
     */
    public function addPoney(Request $request, $id)
    {
        $this->context->cleaning()->AssignPoneyBox($id, $request->poney_id);

        return back()->with('success', 'Poney ajouté avec succès.');
    }

    /**
     * Retire un poney d'un box spécifique.
     *
     * Cette méthode récupère l'ID du poney et supprime son assignation au box en appelant la méthode
     * `RemovePoneyBox`. Un message de succès est ensuite renvoyé à l'utilisateur.
     *
     * @param int $box_id L'ID du box dont le poney doit être retiré (non utilisé dans cette méthode).
     * @param int $poney_id L'ID du poney à retirer du box.
     *
     * @return \Illuminate\Http\RedirectResponse La redirection vers la page précédente avec un message de succès.
     */
    public function removePoney($box_id, $poney_id)
    {
        $this->context->cleaning()->RemovePoneyBox($poney_id);

        return back()->with('success', 'Poney retiré avec succès.');
    }

    /**
     * Nettoie un box spécifique.
     *
     * Cette méthode appelle la fonction `CleanBox` pour nettoyer le box identifié par l'ID
     * passé en paramètre. Un message de succès est ensuite renvoyé à l'utilisateur.
     *
     * @param int $box_id L'ID du box à nettoyer.
     *
     * @return \Illuminate\Http\RedirectResponse La redirection vers la page précédente avec un message de succès.
     */
    public function clean($box_id)
    {
        $this->context->cleaning()->CleanBox($box_id);
        return redirect()->back()->with('success', 'Box nettoyé avec succès !');

    }

    /**
     * Crée un nouveau box de nettoyage.
     *
     * Cette méthode appelle la fonction `NewBox` pour créer un nouveau box. Un message de succès est ensuite
     * renvoyé à l'utilisateur.
     *
     * @return \Illuminate\Http\RedirectResponse La redirection vers la page précédente avec un message de succès.
     */
    public function create_new_box()
    {
        $this->context->cleaning()->NewBox();
        return redirect()->back()->with('success', 'Box créé avec success ');
    }

    /**
     * Supprime un box spécifique.
     *
     * Cette méthode appelle la fonction `DeleteBox` pour supprimer le box identifié par l'ID passé en paramètre.
     * Après la suppression, l'utilisateur est redirigé vers la liste des boxs avec un message de succès.
     *
     * @param int $id L'ID du box à supprimer.
     *
     * @return \Illuminate\Http\RedirectResponse La redirection vers la page de liste des boxs avec un message de succès.
     */
    public function destroy($id)
    {
        $this->context->cleaning()->DeleteBox($id);

        return redirect()->route('box.index')->with('success', 'Box supprimé avec succès.');
    }
}
