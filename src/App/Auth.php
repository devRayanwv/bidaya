<?php
/**
 * User: Rayan Alamer
 * Date: 21/01/16
 * Time: 5:43 PM
 */

namespace Bidaya\App;


use Http\Session;

class Auth
{
    public static function check()
    {
        Session::start();

        if (! Session::loggedIn())
        {
            Session::end();
            header('location: login' );

            exit();
        }
    }
}