<?php

namespace LoveSay\Persistence\Sqlite;

use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;
use LoveSay\Note;
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
                      note_key INTEGER PRIMARY KEY,
                      originator_key INTEGER,
                      message TEXT,
                      view_count INTEGER
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
     * @param int $note_key
     *
     * @return object
     */
    public function fetchObject($originator_key, $note_key)
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('message', 'view_count'))->from('notes')->where('note_key = ?', $note_key)->where('originator_key = ?', $originator_key);

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
        $select->cols(array('message', 'view_count'))->from('notes')->where('originator_key = ?', $originator_key);

        $notes = $this->pdo->fetchObjects($select, $select->getBindValues());

        return $notes;
    }

    /**
     * @param int    $originator_key
     * @param int    $note_key
     * @param string $message
     * @param int    $view_count
     *
     * @return int
     */
    public function store($originator_key, $note_key, $message, $view_count = 0)
    {
        $data_mapping = array(
            'note_key'       => $note_key,
            'originator_key' => $originator_key,
            'message'        => $message,
            'view_count'     => $view_count
        );

        $insert = $this->query_factory->newInsert();
        $insert->into('notes')->cols($data_mapping);

        $this->pdo->perform($insert, $insert->getBindValues());

        return $this->pdo->lastInsertId();
    }

    /**
     * @param int      $originator_key
     * @param Note     $note
     *
     * @return int
     */
    public function update($originator_key, Note $note)
    {
        $data_binding = array(
            'message'        => $note->message(),
            'view_count'     => $note->viewCount(),
            'originator_key' => $originator_key,
            'note_key'       => $note->getKey()
        );

        $update = $this->query_factory->newUpdate();
        $update->table('notes')->cols(array('message', 'view_count'));
        $update->where('originator_key = :originator_key')->where('note_key = :note_key');

        $this->pdo->perform($update, $data_binding);

        $note_data = $this->fetchObject($originator_key, $note->getKey());

        return $note_data->view_count;
    }
}