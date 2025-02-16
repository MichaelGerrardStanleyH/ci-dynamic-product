<?php

namespace App\Models;

use CodeIgniter\Model;

class StaticProductModel extends Model
{
    protected $table = 'static_product';
    protected $primaryKey = 'product_id';
    protected $allowedFields = ['property_name', 'property_value'];
}
