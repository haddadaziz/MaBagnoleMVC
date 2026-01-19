<?php

namespace App\Core;

class Controller
{
    public function model($model)
    {
        // Require model file
        require_once '../App/Models/' . $model . '.php';

        // Instantiate model
        $modelClass = "App\\Models\\" . $model;
        return new $modelClass();
    }

    public function view($view, $data = [])
    {
        if (file_exists('../App/Views/' . $view . '.php')) {
            require_once '../App/Views/' . $view . '.php';
        } else {
            die('View does not exist.');
        }
    }
}
