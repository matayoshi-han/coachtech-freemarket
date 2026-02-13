<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
        if ($this->is('login')) {
            return [
                'email'    => 'required|string|email',
                'password' => 'required|string',
            ];
        }

            return [
                'name'     => 'required|string|max:20',
                'email'    => 'required|string|email',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        $messages = [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email'    => 'メールアドレスはメール形式で入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ];

        if (!$this->is('login')) {
            $messages += [
                'name.required' => 'お名前を入力してください。',
                'name.max' => 'お名前は20文字以内で入力してください。',
                'password.min' => 'パスワードは8文字以上で入力してください。',
                'password.confirmed' => 'パスワードと一致しません。',
                'password_confirmation.required' => 'パスワード確認は必須項目です。',
                'password_confirmation.min' => 'パスワード確認は8文字以上で入力してください。',
            ];
        }

        return $messages;
    }
}
