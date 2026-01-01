<?php

namespace App\Http\Resources;

use TiMacDonald\JsonApi\JsonApiResource;

class ProjectResource extends JsonApiResource
{
    public $attributes = [
        'id',
        'order_id',
        'quote_id',
        'title',
        'amount',
        'quantity',
        'status',
        'notes',
        'created_at',
        'updated_at',
    ];

    public $relationships = [
        'order' => OrderResource::class,
        'quote' => QuoteResource::class,
    ];
}
