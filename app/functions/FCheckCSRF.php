<?php

namespace app\functions;

use Twig\Extension\AbstractExtension;
use Slim\Csrf\Guard;
use Twig\TwigFunction;

class FCheckCSRF extends AbstractExtension{

    protected $csrf;

    public function __construct(Guard $csrf){
        $this->csrf = $csrf;
    }

    public function getFunctions() {
        return [ new TwigFunction('csrf', [$this, 'csrf'])];
    }

    public function csrf(){
        
        return '<input type="hidden" name="'. $this->csrf->getTokenNameKey() .'" value="'. $this->csrf->getTokenName() .'">
            <input type="hidden" name="'. $this->csrf->getTokenValueKey() .'" value="'. $this->csrf->getTokenValue() .'">';
    }
}