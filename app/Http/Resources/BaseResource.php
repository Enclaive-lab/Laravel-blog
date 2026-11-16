<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class BaseResource extends JsonResource
{
    #[Override]
    public function with(Request $request)
    {
        return [
            'success' => true
        ];
    }
}
