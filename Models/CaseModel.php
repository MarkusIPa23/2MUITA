<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseModel extends Model {
    protected $table = 'cases';
    protected $fillable = ['case_no','vehicle_id','declarant_id','receiver_id','status','risk_score','risk_factors'];
    protected $casts = ['risk_factors' => 'array'];

    public function vehicle(): BelongsTo { return $this->belongsTo(Vehicle::class); }
    public function declarant(): BelongsTo { return $this->belongsTo(Party::class,'declarant_id'); }
    public function receiver(): BelongsTo { return $this->belongsTo(Party::class,'receiver_id'); }
    public function cargo(): HasMany { return $this->hasMany(CargoItem::class,'case_id'); }
    public function inspections(): HasMany { return $this->hasMany(Inspection::class,'case_id'); }
    public function documents(): HasMany { return $this->hasMany(Document::class,'case_id'); }
}
