<?php

// send status line
header($response->status->get(), true, $response->status->getCode());

// send non-cookie headers
foreach ($response->headers->get() as $label => $value) {
    header("{$label}: {$value}");
}

// send cookies
foreach ($response->cookies->get() as $name => $cookie) {
    setcookie(
        $name,
        $cookie['value'],
        $cookie['expire'],
        $cookie['path'],
        $cookie['domain'],
        $cookie['secure'],
        $cookie['httponly']
    );
}

// send content
echo $response->content->get();