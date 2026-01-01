<?php

namespace App\Admin\Resources\ProjectResource\Pages;

use App\Admin\Resources\ProjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
}
