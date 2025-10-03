<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExperimentEntry extends Model
{
    protected $table = 'experiment_entries';
    protected $primaryKey = 'entry_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['content_id', 'date', 'metrics'];
    
    protected $casts = [
        'metrics' => 'array'
    ];
    
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}