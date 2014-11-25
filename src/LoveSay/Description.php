<?php

namespace LoveSay;

class Description 
{
    private $descriptions = array(
        'a whimsy',
        'profoundly heartfelt',
        'vulnerability'
    );

    private function __construct(){}

    public static function express()
    {
        $instance = new Description();
        $description = $instance->randomDescription();
        return $description;
    }

    private function randomDescription()
    {
        shuffle($this->descriptions);
        return $this->descriptions[0];
    }
} 