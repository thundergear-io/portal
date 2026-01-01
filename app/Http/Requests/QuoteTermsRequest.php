<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteTermsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'agree_scope' => ['accepted'],
            'agree_timeline' => ['accepted'],
            'agree_payment' => ['accepted'],
            'agree_terms' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'agree_scope.accepted' => 'Please confirm agreement to the project scope.',
            'agree_timeline.accepted' => 'Please confirm acknowledgment of the timeline.',
            'agree_payment.accepted' => 'Please confirm acceptance of the payment terms.',
            'agree_terms.accepted' => 'Please accept the Terms & Conditions to proceed.',
        ];
    }
}
