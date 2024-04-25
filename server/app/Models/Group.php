<?php
namespace App\Models;

use App\Http\Enums\GroupUserStatus;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = [
        'id',
        'name',
        'description',
        'owner_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class,'group_user')
        ->withPivot('status')
        ->withTimestamps();
    }

    public function approvedUsers()
    {
        return $this->users()->wherePivot('status',GroupUserStatus::APPROVED->value);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
//    public function members()
//    {
//        return $this->hasMany(GroupMember::class);
//    }

}


?>
