<?php

require __DIR__ . '/bootstrap.php';

$run = function() {
    $model = new stdClass();
    $model->content = "Include me";
    return include 'tpl/master.tpl.php';
};

echo $run();