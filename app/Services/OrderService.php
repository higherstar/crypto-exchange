<?php
/**
 * Created by PhpStorm.
 * User: Snake
 * Date: 07/12/2017
 * Time: 01:46 PM
 */

namespace App\Services;
use App\User;
use App\Order;
use App\OrderItem;
use DB;
class OrderService
{

    public function getOrderHistoryForUser(User $user)
    {
        $orders = DB::table('order_items')
            ->select(DB::raw('"Buy" as "Type", order_items.created_at "Date_and_Time",'
                .'CONCAT(crypto_amount, " ", cryptocurrencies.shortname) "Amount",'
                .'CONCAT(fiat_amount, " ", fiat_currencies.shortname ) "Value",'
                .'price_per_unit "Rate"'))
            ->join('orders', 'order_id', '=', 'orders.id')
            ->join('cryptocurrencies', 'cryptocurrency_id', '=', 'cryptocurrencies.id')
            ->join('fiat_currencies', 'fiat_currency_id', '=', 'fiat_currencies.id')
            ->where('orders.user_id', $user->id)
            ->whereNull('orders.deleted_at')
            ->get();
        return $orders;
    }
}