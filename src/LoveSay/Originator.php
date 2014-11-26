<?php

namespace LoveSay;

class Originator 
{
    /** @var int */
    private $identifier;

    /**
     * @param $identifier
     */
    public function __construct($identifier)
    {
        if (empty($identifier)) {
            throw new \InvalidArgumentException('Originator must have an identifier');
        }

        $this->identifier = $identifier;
    }

    /**
     * @return int
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getKey()
    {
        return $this->checksum($this->identifier);
    }

    public static function checksum($data)
    {
        return crc32($data);
    }
}