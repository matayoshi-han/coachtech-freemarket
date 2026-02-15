<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'item_name' => 'required',
            'item_brand' => 'nullable',
            'item_description' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png',
            'categories' => 'required',
            'condition' => 'required',
            'item_amount' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'item_name.required' => '商品名は必須です。',
            'item_description.required' => '商品の説明は必須です。',
            'item_description.max' => '商品の説明は255文字以内で入力してください。',
            'image.required' => '画像は必須です。',
            'image.image' => '画像ファイルをアップロードしてください。',
            'image.mimes' => 'JPEGまたはPNG形式の画像をアップロードしてください。',
            'categories.required' => 'カテゴリーは必須です。',
            'condition.required' => '商品の状態は必須です。',
            'item_amount.required' => '価格は必須です。',
            'item_amount.integer' => '価格は整数で入力してください。',
            'item_amount.min' => '価格は0以上で入力してください。',
        ];
    }
}
