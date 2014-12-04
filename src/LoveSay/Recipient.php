<?php

namespace LoveSay;

class Recipient
{
    private $identifier;

    /**
     * @param $identifier
     */
    public function __construct($identifier)
    {
        if (empty($identifier)) {
            throw new \InvalidArgumentException('Recipient must have an identifier');
        }

        $this->identifier = $identifier;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return $this->checksum($this->identifier);
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
}