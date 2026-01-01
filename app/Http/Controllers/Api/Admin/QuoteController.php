<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Admin\Quotes\CreateQuoteRequest;
use App\Http\Requests\Api\Admin\Quotes\DeleteQuoteRequest;
use App\Http\Requests\Api\Admin\Quotes\GetQuoteRequest;
use App\Http\Requests\Api\Admin\Quotes\GetQuotesRequest;
use App\Http\Requests\Api\Admin\Quotes\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Spatie\QueryBuilder\QueryBuilder;

#[Group(name: 'Quotes', weight: 10)]
class QuoteController extends ApiController
{
    /**
     * List Quotes
     */
    #[QueryParameter('per_page', 'How many items to show per page.', type: 'int', default: 15, example: 20)]
    #[QueryParameter('page', 'Which page to show.', type: 'int', example: 2)]
    public function index(GetQuotesRequest $request)
    {
        $quotes = QueryBuilder::for(Quote::class)
            ->allowedFilters(['id', 'status', 'client_email'])
            ->allowedSorts(['id', 'created_at', 'updated_at', 'status'])
            ->simplePaginate(request('per_page', 15));

        return QuoteResource::collection($quotes);
    }

    /**
     * Create a new quote
     */
    public function store(CreateQuoteRequest $request)
    {
        $quote = Quote::create($request->validated());

        return new QuoteResource($quote);
    }

    /**
     * Show a specific quote
     */
    public function show(GetQuoteRequest $request, Quote $quote)
    {
        return new QuoteResource($quote);
    }

    /**
     * Update a specific quote
     */
    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        $quote->update($request->validated());

        return new QuoteResource($quote);
    }

    /**
     * Delete a specific quote
     */
    public function destroy(DeleteQuoteRequest $request, Quote $quote)
    {
        $quote->delete();

        return $this->returnNoContent();
    }
}
