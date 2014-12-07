<?php

namespace LoveSay;

class Relationship
{
    /** @var int */
    private $originator_key;
    /** @var int */
    private $recipient_key;

    /**
     * @param int $originator_key
     * @param int $recipient_key
     */
    public function __construct($originator_key, $recipient_key)
    {
        $this->originator_key = $originator_key;
        $this->recipient_key = $recipient_key;
    }

    public function getKey()
    {
        return $this->originator_key . $this->recipient_key;
    }
} 