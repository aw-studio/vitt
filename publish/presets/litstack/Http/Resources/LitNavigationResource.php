<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Traits\ForwardsCalls;

class LitNavigationResource extends JsonResource
{
    use ForwardsCalls;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'route'       => $this->route->route(),
            'translation' => $this->translation,
            'active'      => $this->active,
            'children'    => self::collection($this->children),
        ];
    }
}
