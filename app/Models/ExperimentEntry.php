<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExperimentEntry extends Model
{
    use HasFactory;

    protected $table = 'experiment_entries';
    protected $primaryKey = 'entry_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['content_id', 'date', 'metrics'];
    
    protected $casts = [
        'date' => 'date',
        'metrics' => 'array',
        'created_at' => 'datetime',
    ];

    // ==================== SCOPES ====================
    public function scopeForContent($query, $contentId)
    {
        return $query->where('content_id', $contentId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
    }

    // ==================== RELATIONSHIPS ====================
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    // ==================== BUSINESS LOGIC METHODS ====================
    public static function createExperimentEntry(array $data)
    {
        $data['entry_id'] = \Illuminate\Support\Str::uuid();
        
        // Convert metrics to JSON if array
        if (isset($data['metrics']) && is_array($data['metrics'])) {
            $data['metrics'] = json_encode($data['metrics']);
        }
        
        return static::create($data);
    }

    public function updateExperimentEntry(array $data)
    {
        // Convert metrics to JSON if array
        if (isset($data['metrics']) && is_array($data['metrics'])) {
            $data['metrics'] = json_encode($data['metrics']);
        }
        
        return $this->update($data);
    }

    public static function getContentEntries($contentId)
    {
        return static::forContent($contentId)
            ->latestFirst()
            ->get();
    }

    // ==================== VALIDATION RULES ====================
    public static function getValidationRules($forUpdate = false)
    {
        $rules = [
            'content_id' => 'required|exists:content,content_id',
            'date' => 'required|date',
            'metrics' => 'nullable|array'
        ];

        if ($forUpdate) {
            $rules['content_id'] = 'sometimes|exists:content,content_id';
            $rules['date'] = 'sometimes|date';
        }

        return $rules;
    }
}