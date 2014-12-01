<?php

namespace LoveSay\Persistence\Sqlite;

use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;
use LoveSay\Note;
use LoveSay\NoteCollection;
use LoveSay\Persistence\NotesStorage;

class SqliteNotesStorage implements NotesStorage
{
    const IN_MEMORY = ':memory:';

    /** @var ExtendedPdo */
    protected $pdo;
    /** @var QueryFactory */
    protected $query_factory;

    /**
     * @param string $filename
     */
    public function __construct($filename = self::IN_MEMORY)
    {
        $this->pdo = new ExtendedPdo("sqlite:{$filename}");
        $this->query_factory = new QueryFactory('sqlite');

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS notes (
                      id INTEGER PRIMARY KEY,
                      originator_key INTEGER,
                      message TEXT
                      )");
    }

    /**
     * @param int $originator_key
     *
     * @return int
     */
    public function fetchCount($originator_key)
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('COUNT(*) AS count'))->from('notes')->where('originator_key = ?', $originator_key);

        $count = $this->pdo->fetchValue($select, $select->getBindValues());

        return $count;
    }

    /**
     * @param int $originator_key
     * @param int $id
     *
     * @return object
     */
    public function fetchObject($originator_key, $id)
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('message'))->from('notes')->where('id = ?', $id)->where('originator_key = ?', $originator_key);

        $note_data = $this->pdo->fetchObject($select, $select->getBindValues());

        return $note_data;
    }

    /**
     * @param int $originator_key
     *
     * @return array
     */
    public function fetchAll($originator_key)
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('message'))->from('notes')->where('originator_key = ?', $originator_key);

        $notes = $this->pdo->fetchObjects($select, $select->getBindValues());

        return $notes;
    }

    /**
     * @param int $originator_key
     * @param int $id
     * @param string $message
     *
     * @return int
     */
    public function store($originator_key, $id, $message)
    {
        $data_mapping = array(
            'id'             => $id,
            'originator_key' => $originator_key,
            'message'        => $message
        );

        $insert = $this->query_factory->newInsert();
        $insert->into('notes')->cols($data_mapping);

        $this->pdo->perform($insert, $insert->getBindValues());

        return $this->pdo->lastInsertId();
    }
} 