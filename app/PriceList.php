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
        $priceList = static::find($id);

        if(!$priceList) return abort(404);
        
        $priceListItems = PriceListItem::where('price_list_id', $id)
            ->where('removed', 0)
            ->join('medicines', 'medicines.id', '=', 'price_list_items.medicine_id')
            ->join('brands', 'brands.id', '=', 'price_list_items.brand_id')
            ->select('price_list_items.*', 'medicines.name as medicine_name', 'brands.name as brand_name')
            ->orderBy('id', 'asc')
            ->get();

        $priceList->items = $priceListItems;

        return $priceList;
    }

    /**
     * 
     */
    public static function change($id, $data)
    {
        $priceList = static::find($id);
        $priceList->updated_at = Carbon::now();
        $priceList->save();

        for ($i = 0; $i < count($data); $i++) { 
            $priceListItems[] = [
                'price_list_id' => $priceList->id,
                'medicine_id' => $data[$i]['medicine_id'],
                'brand_id' => $data[$i]['brand_id'],
                'exp_date' => Carbon::createFromFormat('d/m/Y', $data[$i]['exp_date']),
                'price' => $data[$i]['price'],
                'quantity' => $data[$i]['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $items = PriceListItem::where('price_list_id', $id)->delete();
        PriceListItem::insert($priceListItems);

        return $priceList;
    }

    /**
     * 
     */
    public static function getTheOnlyPriceList()
    {
        $priceListId = PriceList::all()->first()->id;

        return static::getWithItems($priceListId);
    }

    /**
     * 
     */
    public static function massiveUpdate($id, $itemsToAdd, $itemsToUpdate, $itemsToDelete)
    {
        // Add items
        $add = [];
        foreach ($itemsToAdd as $item) {
            $add[] = [
                'price_list_id' => $id,
                'medicine_id' => $item['medicine_id'],
                'brand_id' => $item['brand_id'],
                'exp_date' => Carbon::createFromFormat('d/m/Y', $item['exp_date']),
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        PriceListItem::insert($add);

        // Delete items
        PriceListItem::whereIn('id', $itemsToDelete)->update([ 'removed' => 1 ]);
        
        // Update items
        foreach ($itemsToUpdate as $item) {

            PriceListItem::where('id', $item['id'])->update([
                'medicine_id' => $item['medicine_id'],
                'brand_id' => $item['brand_id'],
                'exp_date' => Carbon::createFromFormat('d/m/Y', $item['exp_date']),
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'updated_at' => Carbon::now(),
            ]);
            
        }
    }
}
