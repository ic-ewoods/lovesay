<?php
/**
 * 
 * This file is part of Aura for PHP.
 * 
 * @package Aura.Framework_Project
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 */

require dirname(__DIR__) . 'bootstrap.php';

/** @var Aura\Web_Kernel\WebKernel $kernel */
$kernel = (new \Aura\Project_Kernel\Factory)->newKernel(
    dirname(__DIR__),
    'Aura\Web_Kernel\WebKernel'
);
$kernel();
