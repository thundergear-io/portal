<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Declined = 'declined';
    case Completed = 'completed';
}
