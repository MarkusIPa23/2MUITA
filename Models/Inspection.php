<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model {
    protected $fillable = ['case_id','performed_by','type','result','comment'];
}
