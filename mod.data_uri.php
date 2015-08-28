<?php
/**
 * Modifier_data_uri
 * Generate Data URI from input
 *
 * @author     Rudy Affandi <rudy@adnetinc.com>
 * @copyright  2015
 * @link       https://github.com/lesaff/statamic-data_uri
 * @license    MIT
 *
 **/
class Modifier_data_uri extends Modifier
{
    var $meta = array(
        'name'       => 'Statamic Data URI Modifier',
        'version'    => '1.0.1',
        'author'     => 'Rudy Affandi',
        'author_url' => 'https://github.com/lesaff'
    );

    public function index($value, $parameters=array()) {

        // Fetch parameter
        // Note: Data URI adds 33% from the original
        // file size. 21440 bytes = 67% of 32000 bytes
        $max_file_size = (isset($parameters[0])) ? $parameters[0] : 21440;

        // Fetch data from template
        $value = Parse::contextualTemplate(trim($this->content), array(), $this->context);

        // Encode to Base64
        return $this->task->encodeDataURI($value, $max_file_size);
    }
}
