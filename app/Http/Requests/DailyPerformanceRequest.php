<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyPerformanceRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'datetime.*'  => 'nullable',
            'comment.*'   => 'nullable|max:500',
        ];
    }
}
