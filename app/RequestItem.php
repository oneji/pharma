<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    /**
     * The request that belong to the item.
     */
    public function request()
    {
        return $this->belongsTo('App\Request');
    }
}
