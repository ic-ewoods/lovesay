<?php

use Aura\Web\WebFactory;
use LoveSay\API\NoteReaderService;
use LoveSay\API\NoteWriterService;

require dirname(__DIR__) . '/bootstrap.php';

require __DIR__ . '/routes.php';
require __DIR__ . '/storage.php';
require __DIR__ . '/auth.php';

$web_factory = new WebFactory($GLOBALS);
$request = $web_factory->newRequest();
$response = $web_factory->newResponse();


$lovesay = function($heading, $content) {
    $model = new stdClass();
    $model->heading = $heading;
    $model->content = $content;
    return include 'tpl/master.tpl.php';
};

$route = getRoute();

$content = "Nothing here";

switch ($route->params['action']) {
    case 'lovesay':
        $content = $lovesay(LoveSay\Description::express());
        break;
    case 'note.browse':
        $note_writer_api = new NoteWriterService($relationship, $storage);
        $notes = $note_writer_api->getAllNotes();
        $note_display = "<h2>All Notes</h2>" . PHP_EOL;
        $note_display .= "<ul>" . PHP_EOL;
        foreach ($notes as $note) {
            $note_display .= "<li><button><a href='/note/{$note->getKey()}'>{$note->getKey()}</a></button> {$note}</li>" . PHP_EOL;
        }
        $note_display .= "</ul>" . PHP_EOL;
        $content = $lovesay(LoveSay\Description::express(), $note_display);
        break;
    case 'note.read':
        $note_reader_api = new NoteReaderService($relationship, $storage);
        $note = $note_reader_api->readNote($route->params['id']);
        $note_display = "<p>{$note->getMessage()}</p>";
        $note_display .= "<p><button><a href='/note'>Back</a></button></p>";
        $content = $lovesay(LoveSay\Description::express(), $note_display);
        break;
}

$response->content->set($content);

require __DIR__ . '/response.php';