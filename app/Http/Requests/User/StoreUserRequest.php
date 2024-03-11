<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;

class StoreUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
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
