<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Role extends Model
{
    use HasFactory;
    /**
     *
     * @var int
     */
    public const IS_USER = 1;

    /**
     *
     * @var int
     */
    public const IS_MODERATOR = 2;

    /**
     *
     * @var int
     */
    public const IS_ADMIN = 3;

    /**
     *
     * @var int
     */
    public const IS_SUPERUSER = 4;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
