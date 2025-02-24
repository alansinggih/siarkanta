<?php

if (!function_exists('getBaseUrl')) {
    function getBaseUrl()
    {
        $currentUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $split = explode("/", $currentUrl)[3];
        return $split == "siarkanta" ? "/siarkanta" : "";
    }
}