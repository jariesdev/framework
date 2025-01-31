<?php
namespace AvoRed\Framework\Database\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPropertyVarcharValue extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['property_id', 'product_id', 'value'];
}
