# Statamic Data-URI modifier and plugin
By Rudy Affandi (2015)

## What is this?
This modifier and plugin will generate Base64 Data URI from your variable or hardcoded image path.

## Changelog
- 1.0.1 - Moved common functions to tasks
- 1.0.0 - Initial release

## Installation
Copy the folder to the `_add-ons` folder and rename it to `data_uri`.

## As a modifier
`{{ image|data_uri }}`

## As a plugin
Takes one parameter `max_file_size`, default value is set to 21440.
Based on 67% of 32kb. Data URI adds about 33% more to the original file size.
`{{ data_uri max_file_size="21440" }}/assets/img/some_image.png{{ /data_uri }}`
