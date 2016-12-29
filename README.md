# PHP Platform Configuration mocking
This package provides APIs to mock the configuration APIs provided by [PHPPlatform/config][PHPPlatformConfig]

> IMPORTANT NOTE!     This package should be used only for developmental purposes and only as [require-dev][ComposerRequireDev] dependency


## Usage

``` PHP
PhpPlatform\Mock\Config\MockSettings::setSettings($package, $settingPath, $settingValue )
```
where ``$package`` is package name , ``$settingPath`` is the path of the settings to be updated and ``$settingValue`` is the new value of the setting 


## Example
_config.json_ in package named __phpplatform/mypackage__
``` JSON
{
    "logs":{
        "error":"/logs/error.log",
        "debug":"/logs/debug.log"
    }
}
```
to set logs.error to new value
``` PHP
PhpPlatform\Mock\Config\MockSettings::setSettings('phpplatform/mypackage','logs.error','/usr/logs/error.log');
```

[PHPPlatformConfig]:https://github.com/PHPPlatform/config
[ComposerRequireDev]:https://getcomposer.org/doc/04-schema.md#require-dev