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
class Tasks_data_uri extends Tasks
{
    var $meta = array(
        'name'       => 'Statamic Data URI Plugin',
        'version'    => '1.0.0',
        'author'     => 'Rudy Affandi',
        'author_url' => 'https://github.com/lesaff'
    );

    public function encodeDataURI($value, $max_file_size)
    {
        // parse the content just in case
        $file_path  = Path::assemble(BASE_PATH, $value);

        // Get file meta
        $finfo      = finfo_open(FILEINFO_MIME_TYPE);
        $file_mime  = finfo_file($finfo, $file_path);

        // Get file size of input
        $size       = filesize($file_path);
        if ($size < $max_file_size)
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
    }
}
