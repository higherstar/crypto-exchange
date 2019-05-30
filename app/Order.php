<?php

namespace App;

use App\API\YallaBit\Bitstamp;
use App\Http\Requests\OrderRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Initializes an order with an order request from the user's first attempt to buy crypto.
     * returns the new order made or NULL if it did not satisfy the conditions.
     *
     * @param OrderRequest $orderRequest
     * @param User $user
     * @return Order|null
     */
    public static function createAndSaveNewOrder(OrderRequest $orderRequest, User $user)
    {
        // Determine what pair the user is trying to buy
        $form_trading_pair_name = $orderRequest->get('trading_pair');

        // Get the amounts of Fiat + Cryptocurrency from the form
        $pair_amounts = $orderRequest->get($form_trading_pair_name);

        // Since in the form we're using xxx/KWD instead of the real xxx/USD, we need to correct the string
        $trading_pair = strtoupper(str_replace("kwd", "/USD", $form_trading_pair_name ));

        // Get the actual TradingPair Object from the database
        $trading_pair = TradingPair::where('display_name', $trading_pair)->first();

        // Check if the trading pair's quote currency is fiat (i.e. xxx/KWD, xxx/USD, xxx/EUR)
        // Confirm that the calculation is fiat based, rather than crypto.. (i.e. user wants to buy 100 KD of crypto)
        if($trading_pair->quote_currency->isFiat() && $fiat_based = $orderRequest->get('fiat_based'))
        {

            // Prepare the new order
            $order = new Order;
            $order->fiat_currency_id = FiatCurrency::where('shortname', 'KWD')->first()->id;
            $order->fiat_based_calculation = true;
            $order->user()->associate($user);
            $order->save();

            // Add the wanted crypto into the order.
            $order->addOrderItem($trading_pair, $pair_amounts['kwd']);

            return $order;
        }

        // Order is not based on fiat OR the TradingPair's quote currency is not fiat
        return null;
    }

    #region Eloquent Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function fiat_currency()
    {
        return $this->belongsTo(FiatCurrency::class);
    }

    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }
    #endregion

    #region Model Functionality
    /**
     * Get the due amount for this order. returns the amount in KWD.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getDueAmount(){
        if($this->fiat_based_calculation)
        {
            return number_format($this->order_items->sum('fiat_amount'), 3);
        }
        else
        {
            throw new \Exception('Non-fiat calculation is not implemented yet');
        }
    }

    /**
     * Get the description for the full order in a single string.
     *
     * @return string
     */
    public function getDescription()
    {
        $productDescription = "";

        $i = 0;
        $order_items_count = $this->order_items->count();
        foreach($this->order_items as $orderItem)
        {
            $productDescription .= $orderItem->getCryptocurrencyName() . "(s): " . $orderItem->crypto_amount;

            if($order_items_count != ++$i)
                $productDescription .= ", ";
        }

        return $productDescription ?: "No Description.";
    }


    /**
     * Add an order item to the order.
     * Takes the trading pair that you want to purchase and an amount in fiat to buy of that trading pair
     *
     * todo: this should be changed to take cryptocurrency instead of trading pair
     * todo: The trading pair should be determined after the cryptocurrency is passed
     * @param TradingPair $trading_pair
     * @param $fiat_amount
     */
    private function addOrderItem(TradingPair $trading_pair, $fiat_amount)
    {
        // Initial Bitstamp to get the latest tickers for all pairs, just incase the cache expired or the system is not fetching.
        app(Bitstamp::class);

        $crypto_amount = number_format( $fiat_amount / $trading_pair->kwd_last_price, 8, '.', '');

        $orderItem = new OrderItem;
        $orderItem->order_id = $this->id;
        $orderItem->cryptocurrency_id = $trading_pair->base_currency->id;
        $orderItem->crypto_amount = $crypto_amount;
        $orderItem->fiat_amount = $fiat_amount;
        $orderItem->price_per_unit = $trading_pair->kwd_last_price;
        $orderItem->save();
    }
    #endregion

}
