<?php

require __DIR__ . '/bootstrap.php';

$run = function() {
    $model = new stdClass();
    $model->content = LoveSay\Description::express();
    return include 'tpl/master.tpl.php';
};

$run();