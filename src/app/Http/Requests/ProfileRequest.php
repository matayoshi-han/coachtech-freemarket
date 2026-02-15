<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        return [
            'profile_image' => 'nullable|image|mimes:jpeg,png',
            'name' => 'required|max:20',
            'postal_code' => 'required|string|max:8|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string',
            'building' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'profile_image.image' => 'プロフィール画像は画像ファイルでなければなりません。',
            'profile_image.mimes' => 'プロフィール画像はJPEGまたはPNG形式でなければなりません。',
            'name.required' => 'ユーザー名は必須です。',
            'name.max' => 'ユーザー名は20文字以内でなければなりません。',
            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.string' => '郵便番号は文字列でなければなりません。',
            'postal_code.max' => '郵便番号はハイフンを含む8文字以内でなければなりません。',
            'postal_code.regex' => '郵便番号は「123-4567」の形式で入力してください。',
            'address.required' => '住所は必須です。',
            'address.string' => '住所は文字列でなければなりません。',
            'building.string' => '建物名は文字列でなければなりません。',
        ];
    }
}
