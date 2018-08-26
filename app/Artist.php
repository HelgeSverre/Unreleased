<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $guarded = [];

    protected $with = ['tracks'];

    public function getAvatarUrl()
    {
        return "http://via.placeholder.com/80x80";
    }

    public function tracks(){
      return $this->hasMany(Track::class);
    }

}
