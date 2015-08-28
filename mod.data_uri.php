<?php
/**
 * Modifier_data_uri
 * Generate Data URI from input
 *
 * @author     Rudy Affandi <rudy@adnetinc.com>
 * @copyright  2015
 * @link       http://github.com/lesaff/statamic-data_uri
 * @license    MIT
 *
 **/
class Modifier_data_uri extends Modifier
{
    var $meta = array(
        'name'       => 'Statamic Data URI Modifier',
        'version'    => '1.0.0',
        'author'     => 'Rudy Affandi',
        'author_url' => 'http://github.com/lesaff'
    );

    public function index($value, $parameters=array()) {
        $file_path = Path::assemble(BASE_PATH, $value);

        // Get file meta
        $finfo      = finfo_open(FILEINFO_MIME_TYPE);
        $file_mime  = finfo_file($finfo, $file_path);

        // Check file size, can't exceed browser limitation
        // Set hard limit, 32kb based on IE limitation
        $hard_limit = 21440;

        // Get file size of input
        $size       = filesize($file_path);

        if ($size  < $hard_limit)
        {
            // Base64 it
            $result = base64_encode(File::get($file_path));

            // Assemble Base64 URL
            $output = 'data:' . $file_mime . ';base64,' . $result;
            dd($output);
            return $output;
        } else {
            // Return original value
            return $value;
        }
    }
}
