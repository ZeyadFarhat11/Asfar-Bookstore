<?php

namespace App\Http\Requests\Admin\V1\Books;

use App\Http\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class books extends FormRequest
{
    use HttpResponse;
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $route = $this->route('book');
        $id = $route ? $route->id : null;
        $ar_en_reg = config('regex.ar_en_reg');
        $mx = 150;

        return [
            'title' => 'bail|required|regex:'.$ar_en_reg."|not_regex:/^^\d+$/|max:$mx|unique:books,title".($id != null ? ",$id,id" : ''),
            'writter' => 'bail|required|regex:'.$ar_en_reg."|not_regex:/^\d+$/|max:$mx",
            'category' => 'bail|required|regex:/\d+/',
            'publisher' => 'bail|required|regex:'.$ar_en_reg."|not_regex:/^\d+$/|max:$mx",
            'vendor' => 'bail|required|regex:'.$ar_en_reg."|not_regex:/^\d+$/|max:$mx",
            'quantity' => 'bail|required|numeric|min:1',
            'price' => 'bail|required|numeric|min:1',
            'img' => 'sometimes|bail|required|image|mimes:jpeg,png,jpg|max:3072',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'title-required',
            'title.regex' => 'title-not-valid',
            'title.not_regex' => 'title-only_numbers',
            'title.unique' => 'title-exists',
            'category.required' => 'cat-required',
            'category.regex' => 'cat-invalid',
            'category.min' => 'cat-invalid',
            'writter.required' => 'writter-required',
            'writter.regex' => 'writter-not-valid',
            'writter.not_regex' => '-only_numbers',
            'publisher.required' => 'publisher-required',
            'publisher.regex' => 'publisher-not-valid',
            'publisher.not_regex' => 'publisher-only_numbers',
            'vendor.required' => 'vendor-required',
            'vendor.regex' => 'vendor-not-valid',
            'vendor.not_regex' => '-only_numbers',
            'img.image' => 'file-not-image',
            'img.mimes' => 'file-extension',
            'img.max' => 'file-big',
            'title.max' => 'title-long',
            'writter.max' => 'writter-long',
            'publisher.max' => 'publisher-long',
            'vendor.max' => 'vendor-long',
            'price.required' => 'price-required',
            'price.numeric' => 'price-invalid',
            'price.min' => 'price-small',
            'quantity.required' => 'quantity-required',
            'quantity.numeric' => 'quantity-invalid',
            'quantity.min' => 'quantity-invalid',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, $this->error('validation errors', 422, ['errors' => $validator->errors()]));
    }
}
