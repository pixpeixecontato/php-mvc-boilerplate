<?php

namespace App\Controllers;

class Login extends Page
{
    public function index()
    {
        return parent::page("pages/login");
    }
}