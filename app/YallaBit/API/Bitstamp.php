<?php
/**
 * Created by PhpStorm.
 * User: Talal
 * Date: 6/21/2017
 * Time: 7:24 PM
 */

namespace App\API\YallaBit;


use App\TradingPair;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Cache;
use Log;
use Mockery\Exception;
use Pusher\Pusher;

/**
 * Class Responsible for all Bitstamp API calls.
 *
 * Class Bitstamp
 * @package App\API\YallaBit
 */
class Bitstamp
{

    #region Cache Constanta
    const BITSTAMP_TICKERS_READY = 'BITSTAMP_TICKER_READY';
    const BITSTAMP_TICKERS = 'BITSTAMP_TICKERS';

    const BITSTAMP_ORDER_BOOKS_READY = 'BITSTAMP_ORDER_BOOKS_READY';
    const BITSTAMP_ORDER_BOOKS = 'BITSTAMP_ORDER_BOOKS';
    const BTCUSD_LAST_PRICE = 'BTCUSD_LAST_PRICE';
    const LTCUSD_LAST_PRICE = 'LTCUSD_LAST_PRICE';
    const XRPUSD_LAST_PRICE = 'XRPUSD_LAST_PRICE';
    const SECONDS_TO_CACHE_FOR = 6;
    #endregion

    private $http_client;
    private $tickers = [];
    public $order_books = [];

    public $is_tickers_from_cache = false;
    public $is_order_books_from_cache = false;


    /**
     * Bitstamp constructor.
     */
    public function __construct()
    {
        $this->http_client = new Client([
            'base_uri' => 'https://www.bitstamp.net/api/v2/',
            'verify' => false
        ]);

        $this->updateAllPairs();
    }

    // just incase we want to change the way we fetch our prices
    public function updateAllPairs()
    {
        $this->getAllOrderBooks();
    }

    public function getAllOrderBooks(){

        // Wait for bitstamp order books to get loaded and saved to DB.
        // As they are being processed by another page request...
        // makeOtherRequestsWaitForOrderBookResults forces the wait here.
        while(Cache::has(static::BITSTAMP_ORDER_BOOKS_READY) && !Cache::get(static::BITSTAMP_ORDER_BOOKS_READY)) ;

        // Check if bitstamp_tickers exist to grab them from DB, or to fetch a live copy.
        if(!Cache::has(static::BITSTAMP_ORDER_BOOKS))
        {

            $this->forceOtherRequestsToWaitForOrderBooksResults();
            $expires_at = Carbon::now()->addSeconds(static::SECONDS_TO_CACHE_FOR);

            foreach (TradingPair::published()->get() as $trading_pair)
            {
                $this->orderBookRequest($trading_pair);
            }

            $this->storeOrderBooksInCache($expires_at);
            $this->is_order_books_from_cache = false;

        }
        else{

            $this->tickers = Cache::get(static::BITSTAMP_TICKERS);
            $this->is_order_books_from_cache = true;
        }
    }

    /**
     * Fetch all tickers from bitstamp and do the necessary
     */
    public function getAllTickers()
    {
        // Wait for bitstamp tickers to get loaded and saved to DB.
        // As they are being processed by another page request...
        // makeOtherRequestsWaitForTickerResults forces the wait here.
        while(Cache::has(static::BITSTAMP_TICKERS_READY) && !Cache::get(static::BITSTAMP_TICKERS_READY)) ;

        // Check if bitstamp_tickers exist to grab them from DB, or to fetch a live copy.
        if(!Cache::has(static::BITSTAMP_TICKERS))
        {

            $this->forceOtherRequestsToWaitForTickerResults();
            $expires_at = Carbon::now()->addSeconds(static::SECONDS_TO_CACHE_FOR);

            foreach (TradingPair::published()->get() as $trading_pair)
            {
                $this->tickerRequest($trading_pair);
            }

            $this->storeTickersInCache($expires_at);
            $this->is_tickers_from_cache = false;

        }
        else{

            $this->tickers = Cache::get(static::BITSTAMP_TICKERS);
            $this->is_tickers_from_cache = true;

        }
    }

    /**
     * Get account balance
     *
     * @return mixed
     */
    public function getBalance()
    {
        $uri = 'balance/';
        $auth_data = $this->getAuthParams();

        $response = \GuzzleHttp\json_decode($this->http_client->post($uri, $auth_data)->getBody());
        return $response;
    }

    //todo:: integrate order book in this
    private function placeLimitOrderRequest()
    {
        //post a limit request.
    }

    /**
     * a single order book request to fetch all info from Bitstamp
     *
     * @param $trading_pair
     */
    private function orderBookRequest($trading_pair)
    {
        $uri = 'order_book/' . $trading_pair->stripped_display_name;

        $order_book = \GuzzleHttp\json_decode($this->http_client->get($uri)->getBody());

        // Only get the top N orders from bids and asks
        $rows_to_keep = 30;
        $order_book->bids = array_slice($order_book->bids, 0 , $rows_to_keep);
        $order_book->asks = array_slice($order_book->asks, 0 , $rows_to_keep);

        $this->order_books[$trading_pair->stripped_display_name] = $order_book;
        $this->order_books[$trading_pair->stripped_display_name]->trading_pair_id = $trading_pair->id;
        $this->updateLastPriceViaOrderBookOnDB($order_book);
    }

    /**
     * a single ticker request to fetch all info from Bitstamp
     *
     * @param TradingPair $trading_pair
     */
    private function tickerRequest(TradingPair $trading_pair)
    {
        $uri = 'ticker/' . $trading_pair->stripped_display_name;

        $ticker = \GuzzleHttp\json_decode($this->http_client->get($uri)->getBody());

        $this->tickers[$trading_pair->stripped_display_name] = $ticker;
        $this->tickers[$trading_pair->stripped_display_name]->trading_pair_id = $trading_pair->id;
        $this->updateLastPriceOnDB($ticker);
    }

    /**
     * Save last price using order book on DB
     * @param $order_book
     */
    private function updateLastPriceViaOrderBookOnDB($order_book)
    {
        $total_ask = 0.00000000;
        $last_price = null;
        foreach ($order_book->asks as $ask_order) // $ask_order[0] = price / $ask_order[1] = amount of base currency
        {
            // Sum the total of ASK in the Quote currency
            $total_ask+= $ask_order[0]*$ask_order[1];
            if($total_ask >= 3000.00)
            {
                $last_price = number_format($ask_order[0], 3, '.','');
                //Log::debug('last_price: ' + $last_price);
                $trading_pair = TradingPair::find($order_book->trading_pair_id);

                $trading_pair->quote_last_price = $last_price;
                $trading_pair->last_price_updated_at = Carbon::createFromTimestamp($order_book->timestamp);

                $trading_pair->save();
                if($trading_pair->display_name == "LTC/USD")
                    $this->triggerPusherPriceUpdateEvent($trading_pair);

                break;
            }
        }

        if($last_price === null)
        {
            throw new Exception('Could not fetch last price from order book');
        }
    }

    /**
     * Save last price on DB
     * @param $ticker
     */
    private function updateLastPriceOnDB($ticker)
    {
        $trading_pair = TradingPair::find($ticker->trading_pair_id);
        $trading_pair->quote_last_price = $ticker->ask;
        $trading_pair->last_price_updated_at = Carbon::createFromTimestamp($ticker->timestamp);

        $trading_pair->save();
        if($trading_pair->display_name == "LTC/USD")
            $this->triggerPusherPriceUpdateEvent($trading_pair);
    }

    /**
     * While order books are currently being fetched, make all other requests wait
     * for result and fetch from cache when they're ready.
     */
    private function forceOtherRequestsToWaitForOrderBooksResults()
    {
        //API Rate limiting .... prevent other pages from making api requests
        $expires_at = Carbon::now()->addSeconds(5);
        Cache::put(static::BITSTAMP_ORDER_BOOKS_READY, false, $expires_at);
    }

    /**
     * While tickers are currently being fetched, make all other requests wait
     * for result and fetch from cache when they're ready.
     */
    private function forceOtherRequestsToWaitForTickerResults()
    {
        //API Rate limiting .... prevent other pages from making api requests
        $expires_at = Carbon::now()->addSeconds(5);
        Cache::put(static::BITSTAMP_TICKERS_READY, false, $expires_at);
    }

    /**
     * Send last price on pusher
     *
     * @param TradingPair $trading_pair
     */
    private function triggerPusherPriceUpdateEvent(TradingPair $trading_pair)
    {
        if($trading_pair->quote_last_price != $this->getQuoteLastPriceFromCache($trading_pair) )
        {
            $options = array(
                'cluster' => 'eu'
            );
            $pusher = new Pusher(
                \Config::get('broadcasting.connections.pusher.key'),
                \Config::get('broadcasting.connections.pusher.secret'),
                \Config::get('broadcasting.connections.pusher.app_id'),
                $options
            );

            $data['rounded_kwd_last_price'] = $trading_pair->rounded_kwd_last_price;

            $pusher->trigger($trading_pair->stripped_display_name, 'price_update', $data);
            $this->storeQuoteLastPriceInCache($trading_pair);
        }
        else{
            // Do not any messages to pusher.
        }
    }

    /**
     * Temporarily store order books in cache to be used for comparisons and decrease pusher messages.
     *
     * @param Carbon $expires_at
     */
    private function storeOrderBooksInCache(Carbon $expires_at)
    {
        // Save order_book for 10 seconds after fetching them
        // $expires_at = Carbon::now()->addSeconds($this->seconds_to_cache_for);
        Cache::put(static::BITSTAMP_ORDER_BOOKS, $this->order_books, $expires_at);

        // announce results for other requests
        Cache::put(static::BITSTAMP_ORDER_BOOKS_READY, true, $expires_at);
    }

    /**
     * Temporarily store tickers in cache to be used for comparisons and decrease pusher messages.
     *
     * @param Carbon $expires_at
     */
    private function storeTickersInCache(Carbon $expires_at)
    {
        // Save tickers for 10 seconds after fetching them
        // $expires_at = Carbon::now()->addSeconds($this->seconds_to_cache_for);
        Cache::put(static::BITSTAMP_TICKERS, $this->tickers, $expires_at);

        // announce results for other requests
        Cache::put(static::BITSTAMP_TICKERS_READY, true, $expires_at);
    }

    /**
     * Cache the Quote price for X minutes
     *
     * @param TradingPair $trading_pair
     */
    private function storeQuoteLastPriceInCache(TradingPair $trading_pair)
    {
        Cache::put( $this->getLastPriceConstantByTradingPair($trading_pair) , $trading_pair->quote_last_price, 5);
    }

    /**
     * Get the Quote last price from cache
     *
     * @param TradingPair $trading_pair
     * @return mixed
     */
    private function getQuoteLastPriceFromCache(TradingPair $trading_pair)
    {
        return Cache::get($this->getLastPriceConstantByTradingPair($trading_pair), false);
    }

    /**
     * Prepare the form data for bitstamp authenticated requests and return the form_data
     *
     * @return array
     */
    private function getAuthParams()
    {

        $nonce = Carbon::now()->timestamp;
        $customer_id = \Config::get('services.bitstamp.customer_id');
        $api_key = \Config::get('services.bitstamp.yallabit.key');
//        var_dump($customer_id);
//        dd($api_key);
        $message = $nonce . $customer_id . $api_key;
        $signature = strtoupper(hash_hmac("sha256", "$message",\Config::get('services.bitstamp.yallabit.secret')));

        return  ['form_params' => [
                    'signature' => $signature,
                    'nonce' => $nonce,
                    'key' => \Config::get('services.bitstamp.yallabit.key')
                ]];
    }

    /**
     * Get the constant that is relating to the passed trading_pair, used for caching calls
     *
     * @param TradingPair $trading_pair
     * @return mixed
     */
    private function getLastPriceConstantByTradingPair(TradingPair $trading_pair)
    {
        // Accessing the correct constant for the trading pair dynamically and caching the last price for 5 minutes.
        // The cache below is used in pusher so we wouldn't push the same price over and over again.
        $constant_accessor = self::class . "::" . strtoupper($trading_pair->stripped_display_name) . "_LAST_PRICE";
        return constant($constant_accessor);
    }






}