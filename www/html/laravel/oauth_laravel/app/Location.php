<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'country', 'state', 'city'
    ];

    public function toArray()
    {
        $attributes = parent::toArray();
        return \Arr::except($attributes, ['created_at', 'updated_at']);
    }
}
