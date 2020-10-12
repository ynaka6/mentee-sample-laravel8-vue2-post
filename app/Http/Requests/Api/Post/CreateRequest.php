<?php

namespace App\Http\Requests\Api\Post;

use Illuminate\Support\Str;
use App\Services\CrawlerSiteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    private $service;

    public function __construct(CrawlerSiteService $service)
    {
        $this->service = $service;
    }

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
        $rules = [
            'message' => [ 'required', 'string', 'min:2', 'max:3000' ],
            'images.*' => ['nullable', 'image', 'max:8192', 'mimes:jpeg,jpg,png,gif']
        ];

        if ($this->product) {
            $rules += [
                'product.price' => [ 'required', 'integer' ],
                'product.payment_count' => [ 'nullable', 'integer' ]
            ];
        }

        return $rules;
    }

    public function validated()
    {
        $validated = parent::validated();
        $validated['user_id'] = Auth::id();
        $validated['hashtags'] = Str::hashtags($validated['message'] ?? '')->toArray();
        $url = Str::matchUrls($validated['message'] ?? '')->first();
        $validated['external_site'] = $url ? $this->service->crawler($url) : null;
        $validated['images'] = collect($validated['images'] ?? [])
            ->map(function ($image) {
                return config('cloudinary.cloud_url')
                    ? optional($image->storeOnCloudinary('post/images'))->getSecurePath()
                    : $image->store('post/images');
            })->toArray()
        ;
                
        return $validated;
    }
}
