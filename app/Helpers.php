<?php

if (!function_exists('getCartCount')) {
    function getCartCount()
    {
        return session()->has('cart') ? count(session('cart')) : 0;
    }
}
