<?php

namespace App\Http\Requests;

use App\Models\Notebook;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreSourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->route('notebook') instanceof Notebook;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'source_type' => ['required', Rule::in(['pdf', 'docx', 'txt', 'url', 'youtube', 'audio', 'video'])],
            'title' => ['nullable', 'string', 'max:255'],
            'source_url' => ['nullable', 'url', 'max:2048'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'upload_file' => [
                'nullable',
                'file',
                'max:51200',
                'mimetypes:text/plain,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,audio/mpeg,audio/wav,audio/x-wav,video/mp4,video/quicktime',
            ],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $type = $this->string('source_type')->toString();
            $hasUpload = $this->hasFile('upload_file');
            $hasUrl = filled($this->input('source_url'));

            if (in_array($type, ['url', 'youtube'], true) && ! $hasUrl) {
                $validator->errors()->add('source_url', 'A URL is required for website and YouTube sources.');
            }

            if (! in_array($type, ['url', 'youtube'], true) && ! $hasUpload) {
                $validator->errors()->add('upload_file', 'A file is required for this source type.');
            }
        });
    }
}
