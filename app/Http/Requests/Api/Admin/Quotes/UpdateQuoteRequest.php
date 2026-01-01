<?php

namespace App\Http\Requests\Api\Admin\Quotes;

use App\Enums\QuoteStatus;
use App\Http\Requests\Api\Admin\AdminApiRequest;
use Illuminate\Validation\Rule;

class UpdateQuoteRequest extends AdminApiRequest
{
    protected $permission = 'quotes';

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'client_email' => ['nullable', 'email', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'brief' => ['nullable', 'string'],
            'timeline' => ['nullable', 'string'],
            'terms' => ['nullable', 'array'],
            'cost_items' => ['nullable', 'array'],
            'status' => ['sometimes', Rule::enum(QuoteStatus::class)],
        ];
    }
}
