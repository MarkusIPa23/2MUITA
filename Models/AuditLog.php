<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model {
    protected $fillable = ['auditable_type','auditable_id','user_id','action','diff','ip','device'];
    protected $casts = ['diff' => 'array'];
    
    public $timestamps = true;

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}