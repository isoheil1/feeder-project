<?php

namespace App\Http\Requests;

use App\Enums\FeedFormats;
use App\Enums\FeedMerchants;
use App\Helpers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Enum;

class ProductFeedRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fileFormat' => ['required', new Enum(FeedFormats::class)],
            'merchant' => ['required', new Enum(FeedMerchants::class)],
        ];
    }

    /**
     * Add parameters to be validated
     * 
     * @return array
     */
    public function all($keys = null)
    {
        return array_replace_recursive(
            parent::all(),
            $this->route()->parameters()
        );
    }

    /**
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $fileFormat = $validator->getData()['fileFormat'];
            $merchant = $validator->getData()['merchant'];
            $fileFormatFlag = false;
            $merchantFlag = false;

            foreach (config('feeder.formatters') as $formatter) {
                if ($formatter[0]->value == $merchant) $merchantFlag = true;
            }

            foreach (config('feeder.builders') as $formatter) {
                if ($formatter[0]->value == $fileFormat) $fileFormatFlag = true;
            }

            if (!($merchantFlag && $fileFormatFlag))
                $validator->errors()->add(
                    'config',
                    'invalid config'
                );
        });
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = ResponseHelper::fail(code: Response::HTTP_BAD_REQUEST, message: trans('errors.400'));

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
