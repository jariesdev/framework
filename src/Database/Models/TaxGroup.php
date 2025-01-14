<?php
namespace AvoRed\Framework\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class TaxGroup extends Model
{
     /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['name', 'description'];
}
