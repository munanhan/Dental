<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    public function store()
    {
        $this->order->name='good_name_2';
        $this->order->save();
    }
}
