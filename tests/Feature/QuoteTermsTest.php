<?php

namespace Tests\Feature;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteTermsTest extends TestCase
{
    use RefreshDatabase;

    public function test_terms_page_displays_payment_schedule_options(): void
    {
        $quote = Quote::factory()->create([
            'status' => QuoteStatus::Pending,
            'total' => 1000,
        ]);

        $response = $this->get(route('quotes.terms', $quote->public_id));

        $response->assertOk();
        $response->assertSee('Select Payment Schedule');
        $response->assertSee('50% Upfront Deposit');
        $response->assertSee('100% Upfront');
    }

    public function test_accept_terms_requires_payment_schedule(): void
    {
        $quote = Quote::factory()->create([
            'status' => QuoteStatus::Pending,
        ]);

        $response = $this->post(route('quotes.terms.accept', $quote->public_id), [
            'agree_scope' => '1',
            'agree_timeline' => '1',
            'agree_payment' => '1',
            'agree_terms' => '1',
            // payment_schedule missing
        ]);

        $response->assertSessionHasErrors('payment_schedule');
    }

    public function test_accept_terms_saves_payment_schedule_and_approves_quote(): void
    {
        $quote = Quote::factory()->create([
            'status' => QuoteStatus::Pending,
            'total' => 1000,
        ]);

        $response = $this->post(route('quotes.terms.accept', $quote->public_id), [
            'payment_schedule' => '50_percent',
            'agree_scope' => '1',
            'agree_timeline' => '1',
            'agree_payment' => '1',
            'agree_terms' => '1',
        ]);

        $response->assertRedirect(route('quotes.checkout', $quote->public_id));

        $quote->refresh();
        $this->assertEquals(QuoteStatus::Approved, $quote->status);
        $this->assertEquals('50_percent', $quote->payment_schedule);
    }
}
