<?php
namespace App\Models;

use App\Models\Comment as ModelsComment;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model {
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['user_id','content'];
    // public function blogPost() {
    //     return $this->belongsTo('App\Models\BlogPost');
    // }
    public function commentable(){
      return $this->morphTo();
    }
    public function user()    {
        return $this->belongsTo('App\Models\User');
    }
    public function scopeLatest(Builder $query){
       return $query->orderBy(static::CREATED_AT,'desc');
    }
    public static function boot(){
      parent::boot(); 
      static::creating(function(ModelsComment $comment) {
        if($comment->commentable_type==App\Model\BlogPost::class){
          Cache::forget("blog-post-{$comment->commentable_id}");
        }
    });
      //static::addGlobalScope(new LatestScope);
    }
}
