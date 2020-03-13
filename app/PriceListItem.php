<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceListItem extends Model
{
    /**
     * The price lists that belong to the item.
     */
    public function price_list()
    {
        return $this->belongsTo('App\PriceList');
    }
}
