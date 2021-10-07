<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property boolean product_visibility
 */
class Option extends Model
{
    const REVIEW_PUBLIC_MODE = 'public';
    const REVIEW_CONSUMER_MODE = 'consumer';
    const REVIEW_DEACTIVE_MODE = 'deactive';

    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_visibility',
        'comments_mode',
        'vote_mode',
    ];

    /**
     * @return bool
     * @author mj.safarali
     */
    public function getIsVisibleAttribute(): bool
    {
        return $this->product_visibility ?? false;
    }

    /**
     * @return array|string[]
     * @author mj.safarali
     */
    public function getFullCommentsModeAttribute(): array
    {
        return [
            'mode' => $this->comments_mode,
            'message' => config("review_message.comments_mode.{$this->comments_mode}")
        ];
    }

    /**
     * @return array
     * @author mj.safarali
     */
    public function getFullVoteModeAttribute(): array
    {
        return [
            'mode' => $this->vote_mode,
            'message' => config("review_message.vote_mode.{$this->vote_mode}")
        ];
    }

    /**
     * @param $query
     * @return mixed
     * @author mj.safarali
     */
    public function scopeVisible($query)
    {
        return $query->where('product_visibility', '=', true);
    }

    /**
     * @return HasMany
     * @author mj.safarali
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
