<?php

namespace App\Observers;

use App\Order;

class OrderObserver
{

    /***
     * When a new model is saved for the first time, the creating and created events will fire.
     * @param Order $order
     */
    public function creating(Order $order)
    {
        info('creating');
        info($order);
    }

    public function created(Order $order)
    {
        info('created');
        info($order);
    }

    /***
     * However, in both cases(create or update), the saving / saved events will fire.
     * @param Order $order
     */
    public function saving(Order $order)
    {
        info('saving');
        info($order);
    }

    public function saved(Order $order)
    {
        info('saved');
        info($order);
    }

    /***
     * The retrieved event will fire when an existing model is retrieved from the database.
     * @param Order $order
     */
    public function retrieved(Order $order)
    {
        info('retrieved');
        info($order);
    }

    /***
     * If a model already existed in the database and the save method is called, the updating / updated events will fire.
     * @param Order $order
     */
    public function updating(Order $order)
    {
        info('updating');
        info($order);
    }

    public function updated(Order $order)
    {
        info('updated');
        info($order);
    }

}
