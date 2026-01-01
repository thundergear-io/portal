<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ProjectItem;

class ProjectItemObserver
{
    public function updated(ProjectItem $projectItem): void
    {
        if ($projectItem->isDirty('status') && $projectItem->status === 'completed') {
            $this->handleProjectCompletion($projectItem);
        }
    }

    protected function handleProjectCompletion(ProjectItem $projectItem): void
    {
        $quote = $projectItem->quote;

        if ($quote) {
            $quote->status = \App\Enums\QuoteStatus::Completed;
            $quote->save();
        }

        if (!$quote || $quote->payment_schedule !== '50_percent') {
            return;
        }

        // Calculate total already invoiced for this project item
        $invoicedTotal = InvoiceItem::where('reference_type', ProjectItem::class)
            ->where('reference_id', $projectItem->id)
            ->sum('price');

        // The quote total is the target amount.
        // Note: quote->total is the full amount.
        $targetTotal = $quote->total;
        
        // If we have already invoiced the full amount (or more), don't invoice again.
        // We use a small epsilon for float comparison just in case, though DB usually handles 2 decimals.
        if ($invoicedTotal >= $targetTotal - 0.01) {
            return;
        }

        $remainingAmount = $targetTotal - $invoicedTotal;

        // Create Invoice for the remainder
        $invoice = Invoice::create([
            'user_id' => $projectItem->order->user_id,
            'currency_code' => $projectItem->order->currency_code,
            'due_at' => now()->addDays(7),
        ]);

        $invoice->items()->create([
            'reference_id' => $projectItem->id,
            'reference_type' => ProjectItem::class,
            'price' => $remainingAmount,
            'quantity' => 1,
            'description' => $projectItem->title . ' (Final Payment)',
        ]);
    }
}
