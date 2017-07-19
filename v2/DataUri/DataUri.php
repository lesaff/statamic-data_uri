<?php

namespace Statamic\Addons\DataUri;

use Statamic\API\File;
use Statamic\API\Path;
use Statamic\Exceptions\ApiNotFoundException;
use Statamic\Extend\Extensible;

class DataUri
{
    use Extensible;

    /**
     * @param string $value
     * @return null|string
     */
    public function encodeDataURI($value)
    {
        // Get browser info (require Useragent addon)
        try {
            $browser = $this->api('Useragent')->getUA();
            $browser_ver = $browser['browser'] . ' ' . $browser['browser_version'];
        } catch (ApiNotFoundException $e) {
            $browser = null;
            $browser_ver = null;
        }

        // IE Restrictions
        $ie_size = 32000;

        /**
         * Create Data-URI based on browser
         * Source: http://caniuse.com/#feat=datauri
         * If IE 7 or older, just show the original image
         * If IE 8, limit to 32kb
         */

        // Encode data
        $output = $this->encoder($value);

        // Check for IE 6, 7, 8 or other
        if ($browser_ver) {
            switch ($browser_ver) {
                case (preg_match('/IE 6.*/', $browser_ver) ? true : false):
                case (preg_match('/IE 7.*/', $browser_ver) ? true : false):
                    // Return original value
                    return $value;
                    break;
                case (preg_match('/IE 8.*/', $browser_ver) ? true : false):
                    if ($output['size'] <= $ie_size) {
                        return $output;
                    } else {
                        return $value;
                    }
                    break;
                default:
                    return $output;
            }
        } else {
            return $output;
        }
    }

    /**
     * Base64 Encoder (internal or external source)
     * @param string $value
     * @return string|null
     */
    private function encoder($value)
    {
        // Base64 it
        if (File::exists(Path::clean($value))) {
            $file_path = Path::assemble(BASE, Path::clean($value));
            $image = file_get_contents($file_path);
            $result = base64_encode($image);

            // Populate array
            $data = [
                'size' => File::size(Path::clean($value)),
                'mime' => File::mimeType(Path::clean($value)),
                'raw' => $result,
                'url' => 'data:' . File::mimeType(Path::clean($value)) . ';base64,' . $result
            ];
            $output = 'data:' . $data['mime'] . ';base64,' . $result;
            return $output;
        }

        return null;
    }
}
