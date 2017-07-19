<?php

namespace Statamic\Addons\DataUri;

use Statamic\Extend\Tags;

class DataUriTags extends Tags
{
    /** @var DataUri */
    protected $helper;

    protected function init()
    {
        $this->helper = new DataUri();
    }

    /**
     * The {{ data_uri }} tag
     *
     * @return string|array
     */
    public function index()
    {
        // Fetch data from template
        $value = $this->content;

        // Encode to Base64
        return $this->helper->encodeDataURI($value);
    }
}
