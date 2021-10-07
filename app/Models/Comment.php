<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    const FIRST_COMMENT_STATUS = 'pending';

    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
        'vote',
        'status',
    ];

    protected $attributes = [
        'status' => self::FIRST_COMMENT_STATUS,
    ];

}
