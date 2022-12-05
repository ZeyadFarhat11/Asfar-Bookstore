<?php

namespace App\Http\Requests\Admin\V1\Books;

use App\Http\Traits\HttpResponse;
use Illuminate\Foundation\Http\FormRequest;

class updatebook extends FormRequest
{
    use HttpResponse;

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
        $book = $this->route("book")->id;
        return [
            'title' => "bail|required|regex:/^[\p{Arabic}\p{Hebrew}a-z ]+/i|unique:books,title,$book,id",
            'author' => "bail|required|regex:/^[\p{Arabic}\p{Hebrew}a-z ]+/i",
            'writter' => "bail|required|regex:/^[\p{Arabic}\p{Hebrew}a-z ]+/i",
            'publisher' => "bail|required|regex:/^[\p{Arabic}\p{Hebrew}a-z ]+/i",
            'vendor' => "bail|required|regex:/^[\p{Arabic}\p{Hebrew}a-z ]+/i",
            'img' => 'sometimes|bail|image|mimes:jpeg,png,jpg|max:3072',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'title-required',
            'title.regex' => 'title-not-valid',
            'title.unique' => 'title-exists',
            'author.required' => 'author-required',
            'author.regex' => 'author-not-valid',
            'writter.required' => 'writter-required',
            'writter.regex' => 'writter-not-valid',
            'publisher.required' => 'publisher-required',
            'publisher.regex' => 'publisher-not-valid',
            'vendor.required' => 'vendor-required',
            'vendor.regex' => 'vendor-not-valid',
            'img.required' => 'img-required',
            'img.image' => 'file-not-image',
            'img.mimes' => 'file-extension',
            'img.max' => 'file-big',
        ];
    }
}
