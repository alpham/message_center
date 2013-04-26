<?php

function prepareURL($get) {
    $url = isset($get['url']) ? $get['url'] : Null;
    $url = rtrim($url, '/');
    $url = explode('/', $url);
    return $url;
}
