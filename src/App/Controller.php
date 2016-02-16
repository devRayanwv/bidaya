<?php

/**
 * User: Rayan Alamer
 * Date: 18/01/16
 * Time: 9:31 PM
 */

namespace Bidaya\App;

use Http\Session;

class Controller
{
    public function __construct()
    {
        Session::start();
    }
}