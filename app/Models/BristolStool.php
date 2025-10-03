<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class BristolStool extends Model
{
    use HasFactory;

    protected $table = 'bristol_stool_entries';
    protected $primaryKey = 'entry_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['user_id', 'date', 'bristol_type', 'notes'];
    
    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];

    // ==================== SCOPES ====================
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
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

    // ==================== RELATIONSHIPS ====================
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==================== BUSINESS LOGIC METHODS ====================
    public static function createEntry(array $data)
    {
        $data['entry_id'] = \Illuminate\Support\Str::uuid();
        $data['user_id'] = Auth::id();
        
        return static::create($data);
    }

    public function updateEntry(array $data)
    {
        return $this->update($data);
    }

    public static function getUserEntries($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        return static::forUser($userId)
            ->latestFirst()
            ->get();
    }

    public static function getEntriesByDateRange($startDate, $endDate, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        return static::forUser($userId)
            ->byDateRange($startDate, $endDate)
            ->latestFirst()
            ->get();
    }

    public static function getTodayEntries()
    {
        return static::forCurrentUser()
            ->where('date', today())
            ->get();
    }

    public static function getStats($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        return static::forUser($userId)
            ->selectRaw('
                COUNT(*) as total_entries,
                AVG(bristol_type) as average_type,
                MIN(date) as first_entry_date,
                MAX(date) as last_entry_date
            ')
            ->first();
    }

    // ==================== VALIDATION RULES ====================
    public static function getValidationRules($forUpdate = false)
    {
        $rules = [
            'date' => 'required|date|before_or_equal:today',
            'bristol_type' => 'required|integer|between:1,7',
            'notes' => 'nullable|string|max:1000'
        ];

        if ($forUpdate) {
            $rules['date'] = 'sometimes|date|before_or_equal:today';
            $rules['bristol_type'] = 'sometimes|integer|between:1,7';
        }

        return $rules;
    }
}