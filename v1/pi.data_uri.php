<?php
/**
 * Plugin_data_uri
 * Generate Data URI from input
 *
 * @author     Rudy Affandi <rudy@adnetinc.com>
 * @copyright  2015
 * @link       https://github.com/lesaff/statamic-data_uri
 * @license    MIT
 *
 */
class Plugin_data_uri extends Plugin
{
    var $meta = array(
        'name'       => 'Statamic Data URI Plugin',
        'version'    => '1.0.3',
        'author'     => 'Rudy Affandi',
        'author_url' => 'https://github.com/lesaff'
    );

    public function index()
    {
        // Fetch data from template
        $value = Parse::contextualTemplate(trim($this->content), array(), $this->context);

        // Encode to Base64
        return $this->tasks->encodeDataURI($value);
    }
}
