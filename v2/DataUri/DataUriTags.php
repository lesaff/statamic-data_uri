<?php

namespace Statamic\Addons\DataUri;

use Statamic\Extend\Tags;

class DataUriTags extends Tags
{
    /**
     * Initialize any classes we'll need
     */
    public function init()
    {
        $this->DataUri = new DataUri;
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
        return $this->DataUri->encodeDataURI($value);
    }
}
