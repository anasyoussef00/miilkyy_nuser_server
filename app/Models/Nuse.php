<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Like;
use App\Models\Dislike;
use App\Models\Nuse;

class Nuse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'location',
        'happened_at',
        // 'trust_points'
    ];

    public function likedByUser($id) {
        return $this->likes->contains('user_id', $id);
    }

    // public function isLikedByUser(User $user, Nuse $nuse)
    // {
    //     return Like::where('user_id', $user->id)->where('nuse_id', $nuse->id)->count() > 0;
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function dislikes()
    {
        return $this->hasMany(Dislike::class);
    }
}
