<?php

namespace App\Http\Requests\Api\Admin\Quotes;

use App\Http\Requests\Api\Admin\AdminApiRequest;

class GetQuoteRequest extends AdminApiRequest
{
    protected $permission = 'quotes';

    public function rules(): array
    {
        return [
            //
        ];
    }
}
