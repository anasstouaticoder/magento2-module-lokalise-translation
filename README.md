<h1 style="text-align: center;">Magento 2 Module AnassTouatiCoder BackToTop</h1>
<div style="text-align: center;">
  <p>Copy field path and value, display its override values in parent scope</p>
  <img src="https://img.shields.io/badge/magento-2.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square" alt="Supported Magento Versions" />
  <a href="https://packagist.org/packages/anasstouaticoder/magento2-module-lokalise-translation" target="_blank"><img src="https://img.shields.io/packagist/v/anasstouaticoder/magento2-module-lokalise-translation.svg?style=flat-square" alt="Latest Stable Version" /></a>
  <a href="https://packagist.org/packages/anasstouaticoder/magento2-module-lokalise-translation" target="_blank"><img src="https://poser.pugx.org/anasstouaticoder/magento2-module-lokalise-translation/downloads" alt="Composer Downloads" /></a>
  <a href="https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity" target="_blank"><img src="https://img.shields.io/badge/maintained%3F-yes-brightgreen.svg?style=flat-square" alt="Maintained - Yes" /></a>
  <a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/badge/license-MIT-blue.svg" /></a>
</div>

    ``anasstouaticoder/magento2-module-back-to-top``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [usage](#markdown-header-usage)
 - [License](#markdown-header-license)


## Main Functionalities
The module add Lokaise translation as new Layer to Magento translation structure 
## Installation
\* = in production please use the `--keep-generated` option

### install from composer 2

 - In magento project root directory run command `composer require anasstouaticoder/magento2-module-lokalise-translation`
 - Enable the module by running `php bin/magento module:enable AnassTouatiCoder_LokaliseTranslation`
 - Flush the cache by running `php bin/magento cache:flush`


### Zip file

 - Unzip the zip file in `app/code/AnassTouatiCoder`
 - Enable the module by running `php bin/magento module:enable AnassTouatiCoder_LokaliseTranslation`
 - Flush the cache by running `php bin/magento cache:flush`

## Configuration

### Configuration In Back Office

To configure the module:

Log in to the Magento admin panel.
Navigate to Stores > Configuration > Atouati Tools > Lokalise Translation.
#### General
- Enable: Toggle to enable or disable the "Back to Top" button globally.
- API Token: you can generate it in Lokalise dashboard then past it in this field
- Project ID: you can copy it from your Lokalise dashboard
- Debug mode: Toggle to enable or disable debug mode to see investigate connection errors.

Then save changes and refresh config and translation caches
## Specifications

This module gives the possibility to integrate Lokalise translations in Magento projects 
## Usage
After Configurating the module, now you juste need to add/modify or remove translation keys in 
lokalise dashboard then purge tranlsation cache in 
MagentO BO
after that the new translations will be displayed in front office

[See plugin wiki](https://github.com/anasstouaticoder/magento2-module-lokalise-translation/wiki/demo)

## Usage
For any issues, suggestions, or contributions, feel free to reach out:

Author: Anass TOUATI
Email: anass1touati@gmail.com

## License

[MIT](https://opensource.org/licenses/MIT)
