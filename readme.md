# Statamic Data-URI modifier and plugin
By Rudy Affandi (2015)
Version 1.0.0

## What is this?
This modifier and plugin will generate Base64 Data URI from your variable or hardcoded image path.

## Changelog
- 1.0.0 - Initial release

## Installation
Copy the folder to the `_add-ons` folder and rename it to `data_uri`.

## As a modifier
`{{ image|data_uri }}`

## As a plugin
`{{ data_uri }}/assets/img/some_image.png{{ /data_uri }}`
