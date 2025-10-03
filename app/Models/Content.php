<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'content';
    protected $primaryKey = 'content_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['creator_id', 'title', 'description', 'content_type', 'media_url', 'categories'];
    
    protected $casts = [
        'media_url' => 'array',
        'categories' => 'array'
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    
    public function experimentEntries()
    {
        return $this->hasMany(ExperimentEntry::class, 'content_id');
    }
}