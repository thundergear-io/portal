<?php

namespace App\Http\Requests\Api\Admin\Projects;

use App\Http\Requests\Api\Admin\AdminApiRequest;

class GetProjectsRequest extends AdminApiRequest
{
    protected $permission = 'projects';

    public function rules(): array
    {
        return [
            //
        ];
    }
}
