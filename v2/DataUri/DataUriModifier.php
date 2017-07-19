<?php

namespace Statamic\Addons\DataUri;

use Statamic\Extend\Modifier;

class DataUriModifier extends Modifier
{
    /** @var DataUri */
    protected $helper;

    protected function init()
    {
        $this->helper = new DataUri();
    }

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
        return $this->helper->encodeDataURI($value);
    }
}
