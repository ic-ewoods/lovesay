<?php

use LoveSay\Persistence\Sqlite\SqliteNotesStorage;

$storage_filename = dirname(__DIR__) . '/say.sqlite3';
$storage = new SqliteNotesStorage($storage_filename);