<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Product extends BaseController
{

    use ResponseTrait;

    public function index()
    {
        // $response = service('router')->handle('/products');
        // dd($response->getBody());

        return view('welcome_message');
    }
}
