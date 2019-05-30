<?php

namespace App\Http\Controllers;

use App\FiatCurrency;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderItem;
use App\Payment;
use App\TradingPair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Services\OrderService;

class OrdersController extends Controller
{

    public $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware(['auth','verified']);
        $this->orderService = $orderService;
    }

    public function store(OrderRequest $orderRequest)
    {
        //todo:: uncomment below, but fix for adding multiple order items to existing orders...
//        if(!Session::has('pending_order'))
//        {
            $order = Order::createAndSaveNewOrder($orderRequest, \Auth::user());
            Session::put('pending_order', $order); // make sure to remove from session after order being completed.
//        }
//        else{
//            $order = Session::get('pending_order');
//        }
        return view('orders.show', compact('order'));

        //Todo:: below is probably going to be handled by PaymentController
        //Todo:: Work on the response page.
//        $payment = new Payment($order);
//        return Redirect::to($payment->payment_url);

    }

    public function fetchStore()
    {
        if(Session::has('pending_order'))
        {
            $order = Session::get('pending_order');
            return view('orders.show', compact('order'));
        }
        return Redirect::home();
    }

    public function index()
    {
        return view('orders.index');
    }

    public function orderHistory()
    {
        $orders = $this->orderService->getOrderHistoryForUser(\Auth::user())->toArray();
        $dataTableArray = [];
        foreach ($orders as $order)
        {
            array_push($dataTableArray, [
                $order->Type,
                $order->Date_and_Time,
                $order->Amount,
                $order->Value,
                $order->Rate,
            ]);
        }
        $dataTableArray = [
            "data" => $dataTableArray
        ];

        return json_encode($dataTableArray);
    }
}
