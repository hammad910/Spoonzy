<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mood extends Model
{
    use HasFactory;

    protected $table = 'mood_tracking';
    protected $primaryKey = 'mood_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['user_id', 'date', 'mood_level', 'tags', 'notes'];
    
    protected $casts = [
        'date' => 'date',
        'tags' => 'array',
        'created_at' => 'datetime',
    ];

    // ==================== SCOPES ====================
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', auth()->id() ?? 1); // Temporary fix
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
    }

    public function scopeByMoodLevel($query, $minLevel, $maxLevel)
    {
        return $query->whereBetween('mood_level', [$minLevel, $maxLevel]);
    }

    public function scopeWithTags($query, array $tags)
    {
        return $query->whereJsonContains('tags', $tags);
    }

    // ==================== RELATIONSHIPS ====================
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==================== BUSINESS LOGIC METHODS ====================
    public static function createMoodEntry(array $data)
    {
        $data['mood_id'] = \Illuminate\Support\Str::uuid();
        $data['user_id'] = auth()->id() ?? 1; // Temporary fix
        
        // Convert tags to array if string
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = json_decode($data['tags'], true);
        }
        
        return static::create($data);
    }

    public function updateMoodEntry(array $data)
    {
        // Convert tags to array if string
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = json_decode($data['tags'], true);
        }
        
        return $this->update($data);
    }

    public static function getUserMoodEntries($userId = null)
    {
        $userId = $userId ?? (auth()->id() ?? 1); // Temporary fix
        
        return static::forUser($userId)
            ->latestFirst()
            ->get();
    }

    public static function getTodayMoodEntries()
    {
        return static::forCurrentUser()
            ->where('date', today())
            ->get();
    }

    public static function getMoodStats($userId = null)
    {
        $userId = $userId ?? (auth()->id() ?? 1); // Temporary fix
        
        return static::forUser($userId)
            ->selectRaw('
                COUNT(*) as total_entries,
                AVG(mood_level) as average_mood,
                MIN(mood_level) as lowest_mood,
                MAX(mood_level) as highest_mood,
                MIN(date) as first_entry_date,
                MAX(date) as last_entry_date
            ')
            ->first();
    }

    public static function getMoodTrends($days = 30)
    {
        $startDate = now()->subDays($days);
        
        return static::forCurrentUser()
            ->where('date', '>=', $startDate)
            ->selectRaw('date, AVG(mood_level) as average_mood')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    public static function getCommonTags($limit = 10)
    {
        return static::forCurrentUser()
            ->whereNotNull('tags')
            ->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(tags, "$")) as tag')
            ->get()
            ->flatMap(function($entry) {
                return $entry->tag ? json_decode($entry->tag, true) : [];
            })
            ->countBy()
            ->sortDesc()
            ->take($limit);
    }

    // ==================== VALIDATION RULES ====================
    public static function getValidationRules($forUpdate = false)
    {
        $rules = [
            'date' => 'required|date|before_or_equal:today',
            'mood_level' => 'required|integer|between:1,10',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'notes' => 'nullable|string|max:1000'
        ];

        if ($forUpdate) {
            $rules['date'] = 'sometimes|date|before_or_equal:today';
            $rules['mood_level'] = 'sometimes|integer|between:1,10';
            $rules['tags'] = 'sometimes|array';
        }

        return $rules;
    }

    // ==================== ACCESSORS & MUTATORS ====================
    public function getMoodDescriptionAttribute()
    {
        $descriptions = [
            1 => 'Very Poor',
            2 => 'Poor',
            3 => 'Fair',
            4 => 'Moderate',
            5 => 'Average',
            6 => 'Good',
            7 => 'Very Good', 
            8 => 'Great',
            9 => 'Excellent',
            10 => 'Perfect'
        ];

        return $descriptions[$this->mood_level] ?? 'Unknown';
    }
}