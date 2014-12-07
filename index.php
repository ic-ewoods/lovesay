<?php

require __DIR__ . 'bootstrap.php';

$run = function() {
    return include __DIR__ . '/tpl/master.tpl.php';
};

$run();
