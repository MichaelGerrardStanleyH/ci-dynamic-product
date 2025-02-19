<?php

namespace App\Models;

use CodeIgniter\Model;

class DynamicProductModel extends Model
{
    protected $table = 'dynamic_product';
    protected $primaryKey = 'product_id';
    protected $allowedFields = ['property_name', 'property_value', 'static_product_id'];
}
