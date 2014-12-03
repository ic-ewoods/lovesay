<?php

namespace LoveSay;

class Note
{
    /** @var string */
    private $message;
    /** @var int */
    private $originator_key;
    /** @var int */
    private $view_count;

    /**
     * @param int    $originator_key
     * @param string $message
     * @param int    $view_count
     */
    public function __construct($originator_key, $message, $view_count = 0)
    {
        $this->originator_key = $originator_key;
        $this->message = $message;
        $this->view_count = max((int)$view_count, 0);
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
    public function viewCount()
    {
        return $this->view_count;
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return $this->checksum($this->message() . $this->originator_key);
    }

    /**
     * @return int
     */
    public function incrementViewCount()
    {
        $this->view_count = $this->viewCount() + 1;

        return $this->view_count;
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
