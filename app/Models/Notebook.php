<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notebook extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'category_id',
        'title',
        'slug',
        'icon',
        'cover_color',
        'cover_image_path',
        'visibility',
        'status',
        'shared_token',
        'ai_title_suggestion',
        'summary',
        'description',
        'smart_tags',
        'featured_at',
        'last_activity_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'smart_tags' => 'array',
            'featured_at' => 'datetime',
            'last_activity_at' => 'datetime',
        ];
    }

    /**
     * Scope a query to notebooks the user can access.
     */
    public function scopeAccessibleBy(Builder $query, ?User $user): Builder
    {
        if (! $user) {
            return $query;
        }

        return $query->where(function (Builder $builder) use ($user): void {
            $builder
                ->where('owner_id', $user->id)
                ->orWhereHas('members', fn (Builder $memberQuery) => $memberQuery->where('users.id', $user->id));
        });
    }

    /**
     * Get the owner of the notebook.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the category for the notebook.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all notebook members.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notebook_members')
            ->withPivot(['id', 'permission', 'can_share', 'invited_by'])
            ->withTimestamps();
    }

    /**
     * Get the member rows for the notebook.
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(NotebookMember::class);
    }

    /**
     * Get the uploaded sources.
     */
    public function sources(): HasMany
    {
        return $this->hasMany(Source::class);
    }

    /**
     * Get the notebook chats.
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    /**
     * Get the notebook embeddings.
     */
    public function embeddings(): HasMany
    {
        return $this->hasMany(AiEmbedding::class);
    }

    /**
     * Get the notebook activity logs.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Determine if the notebook can be accessed by the given user.
     */
    public function isAccessibleBy(?User $user): bool
    {
        if (! $user) {
            return true;
        }

        if ($user->isAdmin() || $this->owner_id === $user->id) {
            return true;
        }

        return $this->members()->where('users.id', $user->id)->exists();
    }

    /**
     * Get the user's permission for the notebook.
     */
    public function userPermission(?User $user): ?string
    {
        if (! $user) {
            return 'owner';
        }

        if ($user->isAdmin() || $this->owner_id === $user->id) {
            return 'owner';
        }

        return $this->members()
            ->where('users.id', $user->id)
            ->value('permission');
    }

    /**
     * Determine whether the user can manage notebook settings.
     */
    public function canManage(?User $user): bool
    {
        return in_array($this->userPermission($user), ['owner', 'editor'], true);
    }
}
