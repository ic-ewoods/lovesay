<?php

namespace LoveSay;

class Note
{
    /** @var string */
    private $text;
    /** @var int */
    private $originator_key;

    /**
     * @param string $text
     * @param int    $originator_key
     */
    public function __construct($text, $originator_key)
    {
        $this->text = $text;
        $this->originator_key = $originator_key;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return $this->checksum($this->getText() . $this->originator_key);
    }

    /**
     * @param $data
     *
     * @return int
     */
    public static function checksum($data)
    {
        return crc32($data);
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->getText();
    }
}
