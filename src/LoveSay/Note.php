<?php

namespace LoveSay;

class Note
{
    /** @var string */
    private $message;
    /** @var int */
    private $relationship_key;
    /** @var int */
    private $view_count;

    /**
     * @param int    $relationship_key
     * @param string $message
     * @param int    $view_count
     */
    public function __construct($relationship_key, $message, $view_count = 0)
    {
        $this->relationship_key = $relationship_key;
        $this->message = $message;
        $this->view_count = max((int)$view_count, 0);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getViewCount()
    {
        return $this->view_count;
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return $this->computeChecksum($this->getMessage() . $this->relationship_key);
    }

    /**
     * @return int
     */
    public function incrementViewCount()
    {
        $this->view_count = $this->getViewCount() + 1;

        return $this->view_count;
    }

    /**
     * @param $data
     *
     * @return int
     */
    public static function computeChecksum($data)
    {
        return crc32($data);
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->getMessage();
    }

}
