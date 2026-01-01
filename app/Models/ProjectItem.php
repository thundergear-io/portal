<?php

namespace App\Models;

use App\Observers\ProjectItemObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ProjectItemObserver::class])]
class ProjectItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'quote_id',
        'title',
        'amount',
        'quantity',
        'status',
        'notes',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
