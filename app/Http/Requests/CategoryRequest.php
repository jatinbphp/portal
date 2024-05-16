<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CategoryRequest extends FormRequest{
   
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('category');
        
        $rules = [
            'name' => [
                'required', 
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'status'    => 'required',
        ];

        return $rules;
    }
}
