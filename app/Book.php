<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    protected $fillable = [
        'name', 'author', 'published_date','category_id','user_id'
    ];

    protected static function boot()
    {
            parent::boot();

            static::addGlobalScope('status', function (Builder $builder) {
                $builder->where('status_', 1);
            });
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function borrowed_user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
