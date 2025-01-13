<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class SelectComponent
 *
 * Represents a select input component that can be used in forms.
 */
class Select_input extends Component
{

    /**
     * @param string $name Le nom de l'input (utilisé pour les formulaires et la validation).
     * @param string $label Le texte affiché comme libellé.
     * @param array $options Un tableau associatif des valeurs pour les options (id => texte)
     * @param mixed|null $selected La valeur sélectionnée par défaut.
     * @param string $placeholder Le texte par défaut pour l'option vide.
     */
    public function __construct(
        protected string $name,
        protected string $label,
        protected array $options = [],
        protected mixed $selected = null,
        protected string $placeholder = 'Sélectionnez une option',
        protected bool $autopost = false
    ) {

    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.select-input');
    }
}
