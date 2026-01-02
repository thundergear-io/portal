<?php

namespace Tests\Feature;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_a_quote_page(): void
    {
        $quote = Quote::factory()->create([
            'title' => 'Project Atlas',
            'client_name' => 'Acme Corp',
            'cost_items' => [
                ['description' => 'Discovery', 'amount' => 1000],
                ['description' => 'Design', 'amount' => 500],
            ],
        ]);

        $response = $this->get(route('quotes.show', $quote));

        $response
            ->assertOk()
            ->assertSee('Project Atlas')
            ->assertSee('Acme Corp')
            ->assertSee('$1,500.00');
    }

    public function test_it_allows_signed_approval(): void
    {
        $quote = Quote::factory()->create(['status' => QuoteStatus::Pending]);

        $url = URL::temporarySignedRoute('quotes.decide', now()->addMinutes(10), ['quote' => $quote]);

        $response = $this->post($url, ['decision' => 'approve']);

        $response->assertRedirect(route('quotes.checkout', $quote));

        $quote->refresh();

        $this->assertEquals(QuoteStatus::Approved, $quote->status);
        $this->assertNotNull($quote->decided_at);
        $this->assertNotNull($quote->decision_ip);
    }

    public function test_it_ignores_duplicate_decisions(): void
    {
        $quote = Quote::factory()->create([
            'status' => QuoteStatus::Approved,
            'decided_at' => now()->subHour(),
        ]);

        $url = URL::temporarySignedRoute('quotes.decide', now()->addMinutes(10), ['quote' => $quote]);

        $response = $this->post($url, ['decision' => 'decline']);

        $response->assertRedirect(route('quotes.show', $quote));

        $quote->refresh();

        $this->assertEquals(QuoteStatus::Approved, $quote->status);
    }
}
