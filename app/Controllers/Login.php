<?php

namespace App\Controllers;

class Login extends Page
{
    public static function index()
    {
        return parent::page("pages/login");
    }
}