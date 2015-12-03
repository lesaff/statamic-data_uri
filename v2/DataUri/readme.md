# Statamic Data URI addon
## for Statamic 2.x

### What is this?
Generate Base64 Data URI from your variable or hardcoded image path.

### Installation
- Copy `DataUri` folder to your `site/addons` folder
- Log on to your control panel, visit `/cp/system/addons`, make sure that `Data URI` is listed
- Click on the Refresh button on the top right of your browser to initialize new addon
- Alternatively, go to your terminal, `cd` to your website root and type `php please addon:refresh` and hit Enter.

### Usage

```
# As a tag
{{ data_uri }}/assets/img/some_image.png{{ /data_uri}}

# As a modifier
{{ some_image | data_uri }}
```