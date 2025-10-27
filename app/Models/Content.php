<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Content extends Model
{
    use HasFactory;

    protected $table = 'experiment';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['creator_id', 'title', 'description', 'content_type', 'media_url', 'categories'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    // ==================== SCOPES ====================
    public function scopeForCurrentUser($query)
    {
        return $query->where('creator_id', auth()->id()); // Temporary fix
    }

    public function scopeForCreator($query, $creatorId)
    {
        return $query->where('creator_id', $creatorId);
    }

    public function scopeByType($query, $contentType)
    {
        return $query->where('content_type', $contentType);
    }

    public function scopeExperiments($query)
    {
        return $query->where('content_type', 'experiment');
    }

    public function scopeDocumentaries($query)
    {
        return $query->where('content_type', 'documentary');
    }

    public function scopeWithCategories($query, array $categories)
    {
        return $query->whereJsonContains('categories', $categories);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }

    // ==================== RELATIONSHIPS ====================
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function experimentEntries()
    {
        return $this->hasMany(ExperimentEntry::class, 'content_id');
    }

    // ==================== BUSINESS LOGIC METHODS ====================
    public static function createContent(array $data)
    {
        $data['content_id'] = Str::uuid();
        $data['creator_id'] = auth()->id(); // Temporary fix

        // Convert arrays to JSON if needed
        if (isset($data['media_url']) && is_array($data['media_url'])) {
            $data['media_url'] = json_encode($data['media_url']);
        }

        if (isset($data['categories']) && is_array($data['categories'])) {
            $data['categories'] = json_encode($data['categories']);
        }

        return static::create($data);
    }

    public function updateContent(array $data)
    {
        // Convert arrays to JSON if needed
        if (isset($data['media_url']) && is_array($data['media_url'])) {
            $data['media_url'] = json_encode($data['media_url']);
        }

        if (isset($data['categories']) && is_array($data['categories'])) {
            $data['categories'] = json_encode($data['categories']);
        }

        return $this->update($data);
    }

    public static function getUserContents($userId = null)
    {
        $userId = $userId ?? (auth()->id()); // Temporary fix

        return static::forCreator($userId)
            ->latestFirst()
            ->get();
    }

    public static function getExperiments($userId = null)
    {
        $userId = $userId ?? (auth()->id());

        return static::with('creator')->forCreator($userId)
            ->experiments()
            ->latestFirst()
            ->get();
    }

    public static function getDocumentaries($userId = null)
    {
        $userId = $userId ?? (auth()->id());

        return static::forCreator($userId)
            ->documentaries()
            ->latestFirst()
            ->get();
    }

    public static function getContentStats($userId = null)
    {
        $userId = $userId ?? (auth()->id());

        return static::forCreator($userId)
            ->selectRaw('
                COUNT(*) as total_contents,
                SUM(CASE WHEN content_type = "experiment" THEN 1 ELSE 0 END) as total_experiments,
                SUM(CASE WHEN content_type = "documentary" THEN 1 ELSE 0 END) as total_documentaries,
                MIN(created_at) as first_content_date,
                MAX(created_at) as last_content_date
            ')
            ->first();
    }

    public function addExperimentEntry(array $entryData)
    {
        return $this->experimentEntries()->create([
            'entry_id' => Str::uuid(),
            'date' => $entryData['date'] ?? now(),
            'metrics' => isset($entryData['metrics']) ?
                (is_array($entryData['metrics']) ? json_encode($entryData['metrics']) : $entryData['metrics'])
                : null
        ]);
    }

    // ==================== VALIDATION RULES ====================
    public static function getValidationRules($forUpdate = false)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'content_type' => 'required|in:experiment,documentary',
            'media_url' => 'nullable|array',
            'media_url.*' => 'url|max:500',
            'categories' => 'nullable|array',
            'categories.*' => 'string|max:100'
        ];

        if ($forUpdate) {
            $rules['title'] = 'sometimes|string|max:255';
            $rules['description'] = 'sometimes|string|max:2000';
            $rules['content_type'] = 'sometimes|in:experiment,documentary';
        }

        return $rules;
    }

    // ==================== ACCESSORS ====================
    public function getMediaUrlsAttribute()
    {
        return is_array($this->media_url) ? $this->media_url : json_decode($this->media_url, true) ?? [];
    }

    public function getCategoryListAttribute()
    {
        return is_array($this->categories) ? $this->categories : json_decode($this->categories, true) ?? [];
    }
}
