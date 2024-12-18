<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordRequest extends FormRequest
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
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'record_name' => ['required', 'string', 'max:100'],
      'record_description' => ['nullable', 'string', 'max:255'],
      'is_possession' => ['nullable', 'boolean'],
    ];
  }
}
