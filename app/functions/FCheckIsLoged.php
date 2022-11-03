<?php

namespace app\functions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FCheckIsLoged extends AbstractExtension {

    public function getFunctions() {
        return [ new TwigFunction('FCheckIsLoged', [$this, 'FCheckIsLoged'])];
    }

    public function FCheckIsLoged() {

        return (isset($_SESSION['usu_is_logged'])) ? 'true': 'false';
    }
}