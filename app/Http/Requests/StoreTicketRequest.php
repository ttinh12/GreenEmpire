<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); // Chỉ cho phép người dùng đã đăng nhập gửi yêu cầu
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:5',
            'content' => 'required|string|min:10',
            'priority' => 'required|integer|in:1,2,3',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề cho phiếu hỗ trợ.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'title.min' => 'Tiêu đề quá ngắn (tối thiểu 5 ký tự).',
            'content.required' => 'Bạn cần nhập nội dung chi tiết để chúng tôi hỗ trợ.',
            'content.min' => 'Nội dung mô tả quá ngắn (tối thiểu 10 ký tự).',
            'priority.required' => 'Vui lòng chọn mức độ ưu tiên.',
            'priority.in' => 'Mức độ ưu tiên không hợp lệ.',
        ];
    }
}
