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
                      relationship_key INTEGER,
                      message TEXT,
                      view_count INTEGER
                      )");
    }

    /**
     * @param int $relationship_key
     *
     * @return int
     */
    public function count($relationship_key)
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('COUNT(*) AS count'))->from('notes')->where('relationship_key = ?', $relationship_key);

        $count = $this->pdo->fetchValue($select, $select->getBindValues());

        return $count;
    }

    /**
     * @param int $relationship_key
     * @param int $note_key
     *
     * @return object
     */
    public function fetch($relationship_key, $note_key)
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array(
                'message',
                'view_count'
            ))->from('notes')->where('note_key = ?', $note_key)->where('relationship_key = ?', $relationship_key);

        $note_data = $this->pdo->fetchObject($select, $select->getBindValues());

        return $note_data;
    }

    /**
     * @param int $relationship_key
     *
     * @return array
     */
    public function fetchAll($relationship_key)
    {
        $select = $this->query_factory->newSelect();
        $select->cols(array('message', 'view_count'))->from('notes')->where('relationship_key = ?', $relationship_key);

        $notes = $this->pdo->fetchObjects($select, $select->getBindValues());

        return $notes;
    }

    /**
     * @param int   $relationship_key
     * @param array $note_data
     *
     * @return int
     */
    public function store($relationship_key, array $note_data)
    {
        $note_data['relationship_key'] = $relationship_key;
        $cols = array('note_key', 'relationship_key', 'message', 'view_count');
        $col_mapping = array_intersect_key($note_data, array_flip($cols));

        $insert = $this->query_factory->newInsert();
        $insert->into('notes')->cols($col_mapping);

        $this->pdo->perform($insert, $insert->getBindValues());

        return $this->pdo->lastInsertId();
    }

    /**
     * @param int  $relationship_key
     * @param Note $note
     *
     * @return int
     */
    public function update($relationship_key, Note $note)
    {
        $data_binding = array(
            'message'          => $note->getMessage(),
            'view_count'       => $note->getViewCount(),
            'relationship_key' => $relationship_key,
            'note_key'         => $note->getKey()
        );

        $update = $this->query_factory->newUpdate();
        $update->table('notes')->cols(array('message', 'view_count'));
        $update->where('relationship_key = :relationship_key')->where('note_key = :note_key');

        $this->pdo->perform($update, $data_binding);

        $note_data = $this->fetch($relationship_key, $note->getKey());

        return $note_data->view_count;
    }
}