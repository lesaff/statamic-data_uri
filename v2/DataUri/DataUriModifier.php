<?php

namespace Statamic\Addons\DataUri;

use Statamic\Extend\Modifier;

class DataUriModifier extends Modifier
{
    /**
     * Modify a value
     *
     * @param mixed $value The value to be modified
     * @param array $params Any parameters used in the modifier
     * @param array $context Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        // Encode to Base64
        return $this->DataUri->encodeDataURI($value);
    }
}
