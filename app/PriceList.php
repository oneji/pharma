<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PriceList extends Model
{
    /**
     * The items that belong to the price list.
     */
    public function price_list_items()
    {
        return $this->hasMany('App\PriceListItem');
    }

    /**
     * 
     */
    public static function getAll()
    {
        return static::all();
    }

    /**
     * 
     */
    public static function create($data)
    {
        $noErrors = true;
        $priceList = new PriceList();
        $priceList->save();

        for($i = 0; $i < count($data); $i++) {
            $priceListItems[] = [
                'price_list_id' => $priceList->id,
                'medicine_id' => $data[$i]['medicine_id'],
                'brand_id' => $data[$i]['brand_id'],
                'exp_date' => Carbon::createFromFormat('d/m/Y', $data[$i]['exp_date']),
                'price' => $data[$i]['price'],
                'quantity' => $data[$i]['quantity'],
                'created_at' => Date('Y-m-d'),
                'updated_at' => Date('Y-m-d'),
            ];
        }

        PriceListItem::insert($priceListItems);

        return $priceList;
    } 

    /**
     * 
     */
    public static function getWithItems($id)
    {
        $priceList = collect(static::find($id));
        $priceListItems = PriceListItem::where('price_list_id', $id)
            ->join('medicines', 'medicines.id', '=', 'price_list_items.medicine_id')
            ->join('brands', 'brands.id', '=', 'price_list_items.brand_id')
            ->select('price_list_items.*', 'medicines.name as medicine_name', 'brands.name as brand_name')
            ->get();

        $priceList->put('items', $priceListItems);

        return $priceList;
    }
}
