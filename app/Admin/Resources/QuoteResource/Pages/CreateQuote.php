<?php

namespace App\Admin\Resources\QuoteResource\Pages;

use App\Admin\Resources\QuoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuote extends CreateRecord
{
    protected static string $resource = QuoteResource::class;
}
