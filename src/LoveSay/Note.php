<?php

namespace LoveSay;

class Note
{
    /** @var string */
    private $message;
    /** @var int */
    private $originator_key;

    /**
     * @param int    $originator_key
     * @param string $message
     */
    public function __construct($originator_key, $message)
    {
        $this->originator_key = $originator_key;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return $this->checksum($this->message() . $this->originator_key);
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
        return $this->message();
    }
}
