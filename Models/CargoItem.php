<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CargoItem extends Model {
    protected $fillable = ['case_id','hs_code','description','value_eur','weight_kg'];
}
