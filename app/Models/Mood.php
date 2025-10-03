<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    protected $table = 'mood_tracking';
    protected $primaryKey = 'mood_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['user_id', 'date', 'mood_level', 'tags', 'notes'];
    
    protected $casts = [
        'tags' => 'array'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}