# Statamic Data-URI modifier and plugin
By Rudy Affandi (2015)

## What is this?
This modifier and plugin will generate Base64 Data URI from your variable or hardcoded image path.
Using UA Parser to detect browser version and act accordingly. For example, if browser is IE 7 or older, it will revert back to the original image.

## Changelog
- 1.0.2 - Added UA parser, detect older IE
- 1.0.1 - Moved common functions to tasks
- 1.0.0 - Initial release

## Installation
Copy the folder to the `_add-ons` folder and rename it to `data_uri`.

## As a modifier
`{{ image|data_uri }}`

## As a plugin
`{{ data_uri }}/assets/img/some_image.png{{ /data_uri }}`
