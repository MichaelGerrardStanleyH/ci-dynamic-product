<?php

namespace App\Controllers;

use App\Models\DynamicProductModel;
use App\Models\StaticProductModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use CodeIgniter\Files\Exceptions\FileNotFoundException;
use Config\Redis;
use Exception;
use Predis\Client;

class ProductRest extends Controller
{
    use ResponseTrait;
    private $db;
    protected $staticProductModel;
    protected $dynamicProductModel;
    protected $redis;

    public function __construct()
    {
        $this->staticProductModel = new StaticProductModel();
        $this->dynamicProductModel = new DynamicProductModel();
        $this->redis = new Client();
    }

    public function index()
    {



        $cacheKey = 'static_products:all';

        if ($this->redis->exists($cacheKey)) {
            $static_products = json_decode($this->redis->get($cacheKey), true);
        } else {

            $static_products = $this->staticProductModel->findAll();

            $this->redis->setex($cacheKey, 600, json_encode($static_products));
        }


        foreach ($static_products as &$static_product) {
            $static_product['dynamic_property'] = $this->dynamicProductModel->where('static_product_id', $static_product['product_id'])->findAll();
        }

        return $this->response->setJSON($static_products);
    }

    public function getById($id)
    {

        $cacheKey = "static_products:$id";


        if ($this->redis->exists($cacheKey)) {
            $static_product = json_decode($this->redis->get($cacheKey), true);
        } else {
            $static_product = $this->staticProductModel->where('product_id', $id)->first();
            if (!$static_product) {
                throw new FileNotFoundException('product tidak ditemukan');
            }
            $static_product['dynamic_property'] = $this->dynamicProductModel->where('static_product_id', $static_product['product_id'])->findAll();
            $this->redis->setex($cacheKey, 600, json_encode($static_product));
        }

        return $this->response->setJSON($static_product);
    }

    public function addDynamicProduct()
    {




        $json = $this->request->getJSON();

        if (!$json) {
            return $this->fail('Invalid JSON input', 400);
        }

        $rules = [
            'property_name'  => 'required',
            'property_value' => 'required',
            'static_product_id'   => 'required'
        ];

        // $data = (array) $json;

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $property_name = $json->property_name;
        $property_value = $json->property_value;
        $static_product_id = $json->static_product_id;


        $this->dynamicProductModel->save([
            'property_name' => $property_name,
            'property_value' => $property_value,
            'static_product_id' => $static_product_id
        ]);


        $static_product = $this->staticProductModel->where('product_id', $static_product_id)->first();
        $static_product['dynamic_property'] = $this->dynamicProductModel->where('static_product_id', $static_product['product_id'])->findAll();;

        $this->redis->del('static_products:all');
        $this->redis->del("static_products:$static_product_id");

        return $this->response->setJSON($static_product);
    }

    public function editDynamicProduct($id)
    {



        $json = $this->request->getJSON();

        if (!$json) {
            return $this->fail('Invalid JSON input', 400);
        }

        $rules = [
            'property_name'  => 'required',
            'property_value' => 'required',
            'static_product_id'   => 'required'
        ];

        // $data = (array) $json;

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }


        $property_name = $json->property_name;
        $property_value = $json->property_value;
        $static_product_id = $json->static_product_id;


        $this->dynamicProductModel->save([
            'product_id' => $id,
            'property_name' => $property_name,
            'property_value' => $property_value,
            'static_product_id' => $static_product_id
        ]);


        $static_product = $this->staticProductModel->where('product_id', $static_product_id)->first();
        $static_product['dynamic_property'] = $this->dynamicProductModel->where('static_product_id', $static_product['product_id'])->findAll();;

        $this->redis->del('static_products:all');
        $this->redis->del("static_products:$static_product_id");


        return $this->response->setJSON($static_product);
    }

    public function getDynamicProductById($id)
    {

        $cacheKey = "dynamic_products:$id";


        if ($this->redis->exists($cacheKey)) {
            $dynamic_product = json_decode($this->redis->get($cacheKey), true);
        } else {
            $dynamic_product = $this->dynamicProductModel->where('product_id', $id)->first();
            $this->redis->setex($cacheKey, 600, json_encode($dynamic_product));
        }

        return $this->response->setJSON($dynamic_product);
    }

    public function deleteDynamicProduct($id)
    {

        $dynamic_product = $this->dynamicProductModel->where('product_id', $id)->first();
        if (!$dynamic_product) {
            throw new FileNotFoundException('product dynamic tidak ditemukan');
        }
        $static_product_id = $dynamic_product['static_product_id'];

        $this->redis->del('static_products:all');
        $this->redis->del("static_products:$static_product_id");

        $this->dynamicProductModel->delete($id);

        return $this->response->setJSON('Delete succesfully');
    }
}
