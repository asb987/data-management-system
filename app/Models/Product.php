<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product';

    protected $primaryKey = 'id_product';

    public function getData($id_product = false, $id_category = false)
    {
        if ($id_product && $id_category) {
            $data = DB::table('product')
                ->select('product.*', 'category.category_name')
                ->join('category', 'product.id_category', '=', 'category.id_category')
                ->where('category.id_category', (int)$id_category)
                ->where('product.id_product', (int)$id_product)
                ->orderBy('id_product', 'desc')->get();    
        } else {
            $data = DB::table('product')
                ->join('category', 'product.id_category', '=', 'category.id_category')
                ->select('product.*', 'category.category_name')
                ->orderBy('id_product', 'desc')->get();
        }

        if ($data) {
            return $data;
        }

        return false;
    }
}
