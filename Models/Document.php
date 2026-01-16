<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Document extends Model {
    protected $fillable = ['case_id','type','file_name','storage_path','uploaded_by'];
}
