<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    const FIRST_COMMENT_STATUS = 'pending';

    /**
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
        'vote',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $attributes = [
        'status' => self::FIRST_COMMENT_STATUS,
    ];

    /**
     * @param $query
     * @return mixed
     * @author mj.safarali
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
