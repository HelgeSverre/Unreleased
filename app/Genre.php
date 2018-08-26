<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = [];

    protected $with = ['tracks'];

    public function artists()
    {
        return $this->hasMany(Artist::class);
    }

    public function tracks(){
      return $this->hasMany(Track::class);
    }
}
