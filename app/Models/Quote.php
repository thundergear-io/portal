<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Quote extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteFactory> */
    use HasFactory;

    protected $fillable = [
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
        'currency',
        'status',
        'payment_schedule',
        'rejection_reason',
        'rejection_message',
        'decided_at',
        'decision_ip',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'cost_items' => 'array',
        'terms' => 'array',
        'status' => QuoteStatus::class,
        'decided_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $quote): void {
            if (blank($quote->public_id)) {
                $quote->public_id = (string) Str::uuid();
            }

            if (blank($quote->status)) {
                $quote->status = QuoteStatus::Pending;
            }
        });
    }

    public function total(): Attribute
    {
        return Attribute::make(
            get: fn (): float => collect($this->cost_items ?? [])->sum('amount')
        );
    }

    public function formattedTotal(): Attribute
    {
        return Attribute::make(
            get: fn (): string => number_format($this->total, 2)
        );
    }

    public function publicUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => rescue(
                fn () => route('quotes.show', ['quote' => $this->public_id], absolute: true),
                null,
                false
            )
        );
    }

    public function getRouteKeyName(): string
    {
        return 'public_id';
    }

    public function currencyModel(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency', 'code');
    }
}
