<?php

namespace LoveSay;

class Note
{
    private $text;
    /** @var Originator */
    private $originator;

    public function __construct($text, Originator $originator)
    {
        $this->text = $text;
        $this->originator = $originator;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getKey()
    {
        return $this->checksum($this->getText() . $this->originator->getKey());
    }

    public static function checksum($data)
    {
        return crc32($data);
    }
}
