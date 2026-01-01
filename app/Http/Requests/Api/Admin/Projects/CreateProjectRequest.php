<?php

namespace App\Http\Requests\Api\Admin\Projects;

use App\Http\Requests\Api\Admin\AdminApiRequest;

class CreateProjectRequest extends AdminApiRequest
{
    protected $permission = 'projects';

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'quote_id' => ['nullable', 'exists:quotes,id'],
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'in:pending,in_progress,review,completed'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
