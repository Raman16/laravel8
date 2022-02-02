<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
  protected $fillable = ['title', 'content', 'user_id'];
  use HasFactory;
  use SoftDeletes;

  public function comments()
  {
    return $this->morphMany('App\Models\Comment','commentable')->latest();
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }

  public function scopeLatest(Builder $query)
  {
    return $query->orderBy(static::CREATED_AT, 'desc');
  }

  public function scopeMostCommented(Builder $query)
  {
    return $query->withCount('comments')->orderBy('comments_count', 'desc');
  }
  public function tags()   {
    return $this->belongsToMany('App\Models\Tag')->withTimestamps();
  }

  public function image(){
    return $this->morphOne('App\Models\Image','imageable');
  }

  public static function boot() {
    //BEFORE boot() to override Global softDeleteScope
    static::addGlobalScope(new DeletedAdminScope);
    parent::boot();
  }
}
