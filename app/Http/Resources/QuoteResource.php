<?php

namespace App\Http\Resources;

use TiMacDonald\JsonApi\JsonApiResource;

class QuoteResource extends JsonApiResource
{
    public $attributes = [
        'id',
        'public_id',
        'title',
        'client_name',
        'client_email',
        'start_date',
        'end_date',
        'brief',
        'timeline',
        'terms',
        'cost_items',
        'status',
        'payment_schedule',
        'rejection_reason',
        'rejection_message',
        'decided_at',
        'decision_ip',
        'total',
        'created_at',
        'updated_at',
    ];

    public $relationships = [
        // Add relationships if needed, e.g., projects
    ];
}
