<?php

namespace App\Http\Controllers;

use App\Enums\QuoteStatus;
use App\Http\Requests\QuoteDecisionRequest;
use App\Http\Requests\QuoteTermsRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\ProjectItem;
use App\Models\Quote;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class QuoteController extends Controller
{
    public function show(Quote $quote): View
    {
        return view('quotes.show', [
            'quote' => $quote,
            'title' => $quote->title,
            'decisionUrl' => URL::temporarySignedRoute(
                'quotes.decide',
                now()->addDay(),
                ['quote' => $quote->public_id]
            ),
        ]);
    }

    public function decide(QuoteDecisionRequest $request, Quote $quote): RedirectResponse
    {
        if ($quote->status !== QuoteStatus::Pending) {
            return redirect()
                ->route('quotes.show', ['quote' => $quote->public_id])
                ->with('quote_status', 'already_decided');
        }

        $decision = $request->input('decision');

        if ($decision === 'approve') {
            $quote->status = QuoteStatus::Approved;
            $quote->payment_schedule = $request->input('payment_schedule');
        } else {
            $quote->status = QuoteStatus::Declined;
            $quote->rejection_reason = $request->input('rejection_reason');
            $quote->rejection_message = $request->input('rejection_message');
        }

        $quote->decided_at = now();
        $quote->decision_ip = $request->ip();
        $quote->save();

        if ($quote->status === QuoteStatus::Approved) {
            return redirect()->route('quotes.checkout', ['quote' => $quote->public_id]);
        }

        return redirect()->route('quotes.show', ['quote' => $quote->public_id])
            ->with('quote_status', $quote->status->value);
    }

    public function terms(Quote $quote): View
    {
        return view('quotes.terms', [
            'quote' => $quote,
            'title' => 'Accept Terms',
        ]);
    }

    public function acceptTerms(QuoteTermsRequest $request, Quote $quote): RedirectResponse
    {
        // Terms accepted; proceed to checkout (requires auth)
        return redirect()->route('quotes.checkout', ['quote' => $quote->public_id]);
    }

    public function checkout(Quote $quote): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('intended', route('quotes.checkout', ['quote' => $quote->public_id]));
        }

        // Check if order already exists
        $existingItem = ProjectItem::where('quote_id', $quote->id)->first();
        if ($existingItem) {
            $invoiceItem = InvoiceItem::where('reference_type', ProjectItem::class)
                ->where('reference_id', $existingItem->id)
                ->first();
            if ($invoiceItem && $invoiceItem->invoice) {
                return redirect()->route('invoices.show', ['invoice' => $invoiceItem->invoice, 'pay' => true]);
            }

            return redirect()->route('projects');
        }

        return DB::transaction(function () use ($quote) {
            $user = Auth::user();
            $currency = config('settings.default_currency');

            $order = Order::create([
                'user_id' => $user->id,
                'currency_code' => $currency,
            ]);

            $amount = $quote->total;
            if ($quote->payment_schedule === '100_percent') {
                $amount = $amount * 0.9; // 10% discount
            } elseif ($quote->payment_schedule === '50_percent') {
                $amount = $amount * 0.5; // 50% upfront
            }

            $projectItem = ProjectItem::create([
                'order_id' => $order->id,
                'quote_id' => $quote->id,
                'title' => $quote->title . ($quote->payment_schedule === '50_percent' ? ' (50% Deposit)' : ''),
                'amount' => $amount,
                'quantity' => 1,
                'status' => 'pending',
            ]);

            $invoice = Invoice::create([
                'user_id' => $user->id,
                'currency_code' => $currency,
                'due_at' => now()->addDays(7),
            ]);

            $invoice->items()->create([
                'reference_id' => $projectItem->id,
                'reference_type' => ProjectItem::class,
                'price' => $amount,
                'quantity' => 1,
                'description' => $projectItem->title,
            ]);

            return redirect()->route('invoices.show', ['invoice' => $invoice, 'pay' => true]);
        });
    }

    public function placeOrder(Request $request, Quote $quote): RedirectResponse
    {
        $request->validate([
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = Auth::user();
        $currency = config('settings.default_currency');

        $order = Order::create([
            'user_id' => $user->id,
            'currency_code' => $currency,
        ]);

        $amount = $quote->total;
        if ($quote->payment_schedule === '100_percent') {
            $amount = $amount * 0.9; // 10% discount
        } elseif ($quote->payment_schedule === '50_percent') {
            $amount = $amount * 0.5; // 50% upfront
        }

        ProjectItem::create([
            'order_id' => $order->id,
            'quote_id' => $quote->id,
            'title' => $quote->title . ($quote->payment_schedule === '50_percent' ? ' (50% Deposit)' : ''),
            'amount' => $amount,
            'quantity' => 1,
            'status' => 'pending',
            'notes' => $request->input('notes'),
        ]);

        return redirect()->route('dashboard')->with('status', 'order_created');
    }
}
