<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplement extends Model
{
    use HasFactory;

    protected $table = 'supplements';
    protected $primaryKey = 'supplement_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['user_id', 'date', 'supplement_name', 'dosage', 'notes'];
    
    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];

    // ==================== SCOPES ====================
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', auth()->id());
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

    public function scopeByName($query, $supplementName)
    {
        return $query->where('supplement_name', 'like', "%{$supplementName}%");
    }

    // ==================== RELATIONSHIPS ====================
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==================== BUSINESS LOGIC METHODS ====================
    public static function createSupplement(array $data)
    {
        $data['supplement_id'] = \Illuminate\Support\Str::uuid();
        $data['user_id'] = auth()->id();
        
        return static::create($data);
    }

    public function updateSupplement(array $data)
    {
        return $this->update($data);
    }

    public static function getUserSupplements($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        return static::forUser($userId)
            ->latestFirst()
            ->get();
    }

    public static function getTodaySupplements()
    {
        return static::forCurrentUser()
            ->where('date', today())
            ->get();
    }

    public static function getSupplementsByDate($date)
    {
        return static::forCurrentUser()
            ->where('date', $date)
            ->get();
    }

    public static function getSupplementStats($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        return static::forUser($userId)
            ->selectRaw('
                COUNT(*) as total_entries,
                COUNT(DISTINCT supplement_name) as unique_supplements,
                MIN(date) as first_entry_date,
                MAX(date) as last_entry_date
            ')
            ->first();
    }

    public static function getFrequentlyUsedSupplements($limit = 5)
    {
        return static::forCurrentUser()
            ->selectRaw('supplement_name, COUNT(*) as usage_count')
            ->groupBy('supplement_name')
            ->orderBy('usage_count', 'desc')
            ->limit($limit)
            ->get();
    }

    // ==================== VALIDATION RULES ====================
    public static function getValidationRules($forUpdate = false)
    {
        $rules = [
            'date' => 'required|date|before_or_equal:today',
            'supplement_name' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000'
        ];

        if ($forUpdate) {
            $rules['date'] = 'sometimes|date|before_or_equal:today';
            $rules['supplement_name'] = 'sometimes|string|max:255';
        }

        return $rules;
    }
}