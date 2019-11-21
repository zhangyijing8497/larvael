<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandPost extends FormRequest
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
        return ['brand_name'=>[
                'required',
                Rule::unique('brand')->ignore(request()->brand_id,'brand_id'),
                ],
                'brand_url' => 'required',
            ];
    }

    /**
        * 获取被定义验证规则的错误消息
        * @return array
        * @translator laravelacademy.org
    */
    public function messages(){
        return [
            'brand_name.required'=>'品牌名称必填',
                'brand_name.unique'=>'品牌名称已存在',
                'brand_url.required'=>'品牌网址必填'
        ];
    }
}
