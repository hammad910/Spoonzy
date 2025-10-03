<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    protected $table = 'supplements';
    protected $primaryKey = 'supplement_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['user_id', 'date', 'supplement_name', 'dosage', 'notes'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}