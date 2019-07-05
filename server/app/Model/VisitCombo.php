<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VisitCombo extends Model
{
    protected $guarded=['id'];
    protected $dispatchesEvents=[
        'creating'=>'App\Events\CreatingEvent',
        'updating'=>'App\Events\UpdatingEvent',
    ];

    public function visitItems()
    {
        $this->belongsToMany(VisitItem::class,'visit_combo_items');
    }
}
