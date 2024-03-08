<?php

namespace App\Http\Requests\ProductDetail;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UpdateProductDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'color_id' => 'required',
            'size_id' => 'required',
            'product_id' => 'required',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'error' => $validator->errors(),

        ], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw (new ValidationException($validator, $response));
    }
}
