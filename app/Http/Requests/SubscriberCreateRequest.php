<?php


namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubscriberCreateRequest extends FormRequest
{

    use ResponseTrait;
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
            'user_id' => 'required|integer|exists:users,id',
            'website_id' => 'required|integer|exists:websites,id',
        ];
    }

     /**
     * Throws an exception that shows the error messages
     *
     * @return exception
     */
    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException($this->error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
