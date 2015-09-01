<?php
/**
 * Tasks_data_uri
 * Generate Data URI from input
 *
 * @author     Rudy Affandi <rudy@adnetinc.com>
 * @copyright  2015
 * @link       https://github.com/lesaff/statamic-data_uri
 * @license    MIT
 *
 */

require __DIR__ . '/vendor/autoload.php';
use UAParser\Parser;

class Tasks_data_uri extends Tasks
{
    var $meta = array(
        'name'       => 'Statamic Data URI Plugin',
        'version'    => '1.0.3',
        'author'     => 'Rudy Affandi',
        'author_url' => 'https://github.com/lesaff'
    );

    public function encodeDataURI($value)
    {
        // Get browser info
        $browser     = static::getBrowserInfo();
        $browser_ver = $browser['browser_name'] . ' ' . $browser['browser_version_major'];

        // IE Restrictions
        $ie_size     = 32000;

        /**
         * Create Data-URI based on browser
         * Source: http://caniuse.com/#feat=datauri
         * If IE 7 or older, just show the original image
         * If IE 8, limit to 32kb
         */

        // Encode data
        $output = static::encoder($value);

        switch($browser_ver)
        {
            case 'IE 6':
            case 'IE 7':
                // Return original value
                return $value;
                break;
            case 'IE 8':
                if ($output['size'] <= $ie_size) {
                    return $output['url'];
                } else {
                    return $value;
                }
                break;
            default:
                return $output['url'];
        }
    }

    /**
    * Base64 Encoder (internal or external source)
    * @return string
    */
    public function encoder($value)
    {
        // Base64 it
        if (static::checkExtURL($value))
        {
            $file_path = static::cleanURL($value);
            $result    = base64_encode(static::getExtContent($file_path));
        } else {
            $file_path = Path::assemble(BASE_PATH, static::cleanURL($value));
            $result    = base64_encode(File::get($file_path));
        }

        // Populate array
        $data = [
            'size' => filesize($file_path),
            'mime' => finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_path),
            'raw'  => $result,
            'url'  => 'data:' . finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_path) . ';base64,' . $result
        ];
        return $data;
    }

    /**
    * Browser UA detector
    * @return string
    */
    public function getBrowserInfo()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $parser = Parser::create();
        $result = $parser->parse($ua);
        $browser_info = array(
            "browser_name"          => $result->ua->family,
            "browser_version_major" => $result->ua->major,
            "browser_version_minor" => $result->ua->minor,
            "browser_version_patch" => $result->ua->patch,
            "os_name"               => $result->os->family,
            "os_version_major"      => $result->os->major,
            "os_version_minor"      => $result->os->minor,
            "os_version_patch"      => $result->os->patch,
            "device_type"           => $result->device->family,
            "device_brand"          => $result->device->brand,
            "device_model"          => $result->device->model,
            "browser_ua"            => $result->originalUserAgent
        );

        return $browser_info;
    }

    /**
    * Check URL for external/internal
    * @return bool
    */
    public function checkExtURL($url)
    {
        if (substr($url, 0, 4) == "http") {
            return true;
        }
    }

    /**
    * Clean URL from query strings
    * @return string
    */
    public function cleanURL($url)
    {
        return preg_replace('/\?.*/', '', $url);
    }

    /**
    * Grab external content
    * @return mixed
    */
    public function getExtContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
