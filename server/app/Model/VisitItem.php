<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VisitItem extends Model
{
    protected $guarded=['id'];

    protected $dispatchesEvents=[
        'creating'=>'App\Events\CreatingEvent',
        'updating'=>'App\Events\UpdatingEvent',
    ];

    public function visitCombos()
    {
        $this->belongsToMany(VisitCombo::class,'visit_combo_items');
    }
}
