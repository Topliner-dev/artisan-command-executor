<?php

declare(strict_types=1);

namespace Topliner\ArtisanCommandExecutor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtisanExecuteCommandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'input' => 'required|string|min:1|max:65535',
        ];
    }
}