# Diglin_UIOptimization #

It is a Magento module which allows you to optimize and minify your css and js files by allowing you to use different available compression libraries and methods. It's completely configurable following the capabilities of each libraries

## Features

- Available libraries CSSTidy, JSMin ( Douglas Crockford), Google Minify (Same as the one of Fooman Speedster) or the YUI Compressor (Java required).
- Compatible with the merging CSS and JS feature of Magento
- Works with any css and js files included in layout files using action methods: addCss, addJs, and addItem (skin_js, skin_css and js)
- It doesn't modifiy your originals files
- Update the optimized files when the original are modified automatically or periodically (sunday at 2:00 or configurable via Magento cron). Generate a unique file to force browser refreshing if the file has been modified.
- Compatible with https website and relative urls. (it fixes a bug in Magento prior to 1.5.1)

## Canonical URL

Inspired by the module from Yoast, this feature allows you to create canonical urls of your catalog (products, categories, search products and cms pages). Please visit the website of Yoast for more information: http://yoast.com/articles/magento-seo/

This feature is implemented in this module too, to help you to have less as possible different modules.

## HTML and CSS validator

- Enable / disable each function
- Use the W3C Webservice validator
- For testing purpose, display at the bottom of each page of your Magento frontend the validation of your CSS or HTML. Don't use both otherwise it will be slow to display each page.
- Allow you to configure default and / or fallback values (doctype, charset, language, ...)
- Allow you to define a local HTML validator server for quickest validation and local development (No local CSS validator server available for the moment). In local development, you need to do it otherwise the W3C Validator could not get access to your local development website

## Requirements

- If you wish to use YUI Compressor. Java on your server is required. You need to provide in the configuration of this module, the path of the binary if different of the environnement default one.

## Documentation:

### Via Magento Connect
- You can install the current stable version via [MagentoConnect](http://www.magentocommerce.com/magento-connect/js-css-compression-and-minify-user-interface-optimization.html)

### Via modman
- Install [modman](https://github.com/colinmollenhour/modman)
- Use the command from your Magento installation folder: `modman clone https://github.com/diglin/Diglin_UIOptimization.git`

### Manually
- You can copy the files from the folders of this repository to the same folders of your installation

### Optionaly

- For those who use the CommerceBug module, contact me to give you the scripts for it. The script for CommerceBug display the W3C validator for HTML and CSS.

## Configuration

Follow the instructions in the configuration page
In case of Access Denied in the backend: clear your cache, logout/login. In case, it still doesn't work, save again the user role in System > Permissions > Roles.
This module is not compatible with Fooman Speedster and Yoast Canonical Url modules. Deactivate them before to use this module by editing the app/etc/modules/MODULE_TO_DEACTIVATE.xml of the module and set enable to false.

## Deinstall

- If you used MagentoConnect, you may use the deinstall process of the Magento Connect Backend page view of your Magento installation.
- Otherwise remove the files following the hierarchy of the folders of this repository

## Author

* Sylvain Rayé
* http://www.sylvainraye.com/
* [@sylvainraye](https://twitter.com/sylvainraye)
* [Follow me on github!](https://github.com/diglin)

## Donation

[Invite me for a drink](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y66QHLU5VX5BC)

## Profiling

As promised, I provide you below the statistic of compression and ratio by using the different libraries:

Compressed/Minified file statistic and comparison by using default Magento template, sample data, configuration for Diglin User Interface Optimization module is for all by default. Only the method to compress/minify is changed. Merging file has no influence on compression but has influence on number of HTTP requests which is also an important point.

**** JS compression (analyzed with YSlow):

- no compression, no miniying, no merging:  329.8 Kb

- JSMin (unmerged, no gzip): total 230.4Kb (31% of compression)
- JSMin (merged, no gzip): total 230.4Kb
- JSMin (merged, gzip): total 56.8Kb (compression 83%)

- YUI compressor (unmerged, no gzip): total 193.6 Kb (compression 41%)
- YUI compressor (merged, no gzip): total 193.6 Kb
- YUI compressor (merged, gzip): total 52.6 Kb (compression 84%)

- Packed (unmerged, no gzip): total 133.5 Kb (compression 59%)
- Packed (merged, no gzip): total 133.5 Kb
- Packed (merged, gzip): total 44.5 Kb (compression 86.5%)

**** CSS compression (analyzed with YSlow):

- no compression, no miniying, no merging, no gzip: 95.9 kb

- CSS Tidy (unmerged, no gzip): total 79.8 Kb (compression 17%)
- CSS Tidy (merged, no gzip): total 79.8 Kb
- CSS Tidy (merged, gzip): total 14.7 Kb (compression 85%)

- YUI compressor (unmerged, no gzip): total 82.7 Kb (compression 14%)
- YUI compressor (merged, no gzip): total 82.7 Kb - YUI compressor (merged, gzip): total 14.5 Kb (compression 85%)

- Google Minify (unmerged, no gzip): total 79.9 Kb (compression 17%)
- Google Minify (merged, no gzip): total 79.9 Kb - Google Minify (merged, gzip): total 14.9 Kb (compression 84.5%)

CONCLUSION:

- for JS: 1) YUICompressor 2) JSMin 3) Packed (for compatibility problem with Magento)
- for CSS: 1) CSSTidy 2) Google Minify (almost good as CSSTidy) 3) YUICompressor