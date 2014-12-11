<?php

use LoveSay\Originator;
use LoveSay\Recipient;
use LoveSay\Relationship;

$originator = new Originator('me');
$recipient = new Recipient('you');
$relationship = new Relationship($originator->getKey(), $recipient->getKey());
