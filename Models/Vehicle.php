<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model {
    protected $fillable = ['external_id','plate_no','country','make','model','vin'];
    public function cases(): HasMany { return $this->hasMany(CaseModel::class); }
}
