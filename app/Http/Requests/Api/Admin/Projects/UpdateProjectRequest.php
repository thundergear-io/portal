<?php

namespace App\Http\Requests\Api\Admin\Projects;

use App\Http\Requests\Api\Admin\AdminApiRequest;

class UpdateProjectRequest extends AdminApiRequest
{
    protected $permission = 'projects';

    public function rules(): array
    {
        return [
            'order_id' => ['sometimes', 'exists:orders,id'],
            'quote_id' => ['nullable', 'exists:quotes,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'quantity' => ['sometimes', 'integer', 'min:1'],
            'status' => ['sometimes', 'string', 'in:pending,in_progress,review,completed'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
