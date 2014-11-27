<?php

namespace LoveSay;

class NoteCollection implements \ArrayAccess, \Iterator, \Countable
{

    protected $notes = array();

    /**
     * @param Note $note
     */
    public function add(Note $note)
    {
        $this->notes[] = $note;
    }

    /**
     * @param mixed $offset
     * @param Note  $value
     */
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof Note) {
            throw new \InvalidArgumentException('A NoteCollection item must be a Note');
        }
        if (is_null($offset)) {
            $this->notes[] = $value;
        } else {
            $this->notes[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->notes[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->notes[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return Note|null
     */
    public function offsetGet($offset)
    {
        return isset($this->notes[$offset]) ? $this->notes[$offset] : null;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->notes);
    }

    /**
     * @return Note|boolean the value of the first notes element, or false if the notes is
     * empty.
     */
    public function rewind()
    {
        return reset($this->notes);
    }

    /**
     * Return current item in iteration
     *
     * @return Note
     */
    public function current()
    {
        return current($this->notes);
    }

    /**
     * Return key of current item of iteration
     *
     * @return integer
     */
    public function key()
    {
        return key($this->notes);
    }

    /**
     * Move to next item
     *
     * @return Note|boolean
     * the item value in the next place that's pointed to by the
     * internal array pointer, or false if there are no more elements.
     */
    public function next()
    {
        return next($this->notes);
    }

    /**
     * Is the current item of iteration valid?
     *
     * @return bool
     */
    public function valid()
    {
        $key = key($this->notes);

        return ($key !== null && $key !== false);
    }

}