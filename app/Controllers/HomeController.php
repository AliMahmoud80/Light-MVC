<?php


namespace App\Controllers;

use Light\Views\ViewHandler as View;
use Light\Database\DatabaseHandler as Database;

class HomeController
{
    public function index(){


        // Set Language File
        $data['lang_file'] = 'index';

        // Connect To DB
        Database::connect();

        // Render The View File
        View::render('index', $data);
    }

    public function user($data){
    	echo 'user' . $data[0];
    }
}