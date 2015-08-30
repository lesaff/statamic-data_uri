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
        'version'    => '1.0.2',
        'author'     => 'Rudy Affandi',
        'author_url' => 'https://github.com/lesaff'
    );

    public function encodeDataURI($value)
    {
        // parse the content just in case
        $file_path   = Path::assemble(BASE_PATH, $value);

        // Get file meta
        $finfo       = finfo_open(FILEINFO_MIME_TYPE);
        $file_mime   = finfo_file($finfo, $file_path);

        // Get file size of input
        $size        = filesize($file_path);
        $browser     = self::getBrowserInfo();
        $browser_ver = $browser['browser_name'] . ' ' . $browser['browser_version_major'];

        // Restrictions
        $ie_size     = 32000;

        // Create Data-URI based on browser
        // Source: http://caniuse.com/#feat=datauri

        // If IE 7 or older, just show the original image
        if ($browser['browser_name'] && $browser['browser_version_major'] < 8)
        {
            return $value;
        } elseif ($browser['browser_name'] && $browser['browser_version_major'] > 7)
        // If IE 8 or newer, limit to 32kb or smaller (IE restriction)
        {
            if ($size <= $ie_size)
            {
                // Base64 it
                $result = base64_encode(File::get($file_path));

                // Assemble Base64 URL
                $output = 'data:' . $file_mime . ';base64,' . $result;
                return $output;
            } else {
                // Return original value
                return $value;
            }
        } else
        {
            // Rest of the modern browsers
            // Base64 it
            $result = base64_encode(File::get($file_path));

            // Assemble Base64 URL
            $output = 'data:' . $file_mime . ';base64,' . $result;
            return $output;
        }
    }

    public function getBrowserInfo() {
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
}
