<?php
/**
 * User: Rayan Alamer
 * Date: 11/02/16
 * Time: 1:58 PM
 */

namespace Bidaya\App;



class Response extends \Http\Response
{
    public $path;

    public function view($view, $data = [])
    {
        foreach ($data as $key => $value)
        {
            $this->{$key} = $value;
        }

        $this->send();
        require_once $this->path . $view;
    }

    public function json($data)
    {

        $this->headers->add(['Content-Type' => 'application/json']);
        $this->send();
        echo json_encode($data);

    }
}