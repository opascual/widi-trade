<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException; 

class ShortenUrlRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'url' => 'required|string'
        ];
    }

    /**
     * Set custom messages for the validation rules
     */
    public function message(): array
    {
        return [
            'required' => 'The url parameter is mandatory',
            'string' => 'The url parameter must be a string'
        ];
    }

    /**
     * Set error messages to display on a failed validation
     */
    protected function failedValidation(Validator $validator): JsonResponse 
    { 
        $output = ["success" => false, "code" => 422]; 
        foreach($validator->errors()->toArray() as $key => $error) { 
            $output["error"][$key] = end($error); 
        }
 
        throw new HttpResponseException( response()->json($output) ); 
    } 
}