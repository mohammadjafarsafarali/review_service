<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property boolean product_visibility
 */
class Option extends Model
{
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
     * @param $query
     * @return mixed
     * @author mj.safarali
     */
    public function scopeVisible($query)
    {
        return $query->where('product_visibility', '=', true);
    }
}
