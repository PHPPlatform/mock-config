<?php
/**
 * User: Raaghu
 * Date: 22-09-2015
 * Time: PM 10:36
 */

namespace PhpPlatform\Mock\Config;

use PhpPlatform\Config\Settings;
use PhpPlatform\Config\SettingsCache;

class MockSettings extends Settings{

    /**
     * This methods sets new value $settingValue for provided $settingPath, 
     * 
     * This value is retained till the next call of SettingsCache::reset();
     * 
     * @param string $package
     * @param string $settingPath
     * @param mixed $settingValue
     */
    public static function setSettings($package, $settingPath, $settingValue ){
    	
    	//load the settings for this package , if they are not loaded 
    	parent::getSettings($package);
    	
    	$settingPaths = self::getPaths(preg_replace('/\/|\\\\/', ".", $package).".".$settingPath);
    	
    	$settingsCache = SettingsCache::getInstance();
    	
    	$settingsCacheReflection = new \ReflectionClass(get_class($settingsCache));
    	$settingsCacheReflectionProperty = $settingsCacheReflection->getProperty("settings");
    	$settingsCacheReflectionProperty->setAccessible(true);
    	
    	$currentSettings = $settingsCacheReflectionProperty->getValue($settingsCache);
    	
    	$currentSettingsForProvidedPath = &$currentSettings;
    	foreach ($settingPaths as $settingPath_){
    		if(!isset($currentSettingsForProvidedPath[$settingPath_])){
    			$currentSettingsForProvidedPath[$settingPath_] = array();
    		}
    		$currentSettingsForProvidedPath = &$currentSettingsForProvidedPath[$settingPath_];
    	}
    	
    	$currentSettingsForProvidedPath = $settingValue;
    	
    	$settingsCacheReflectionProperty->setValue($settingsCache, $currentSettings);

    }
    	
    
    /**
     * this method get the path array from string key
     * @param string $key
     */
    private static function getPaths($key){
    	$paths = array();
    	$sourcePaths = explode(".", $key);
    	foreach ($sourcePaths as $sourcePath){
    		$subPaths = preg_split('/\[(.*?)\]/',$sourcePath,-1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
    		if($subPaths !== FALSE){
    			$paths = array_merge($paths,$subPaths);
    		}
    	}
    	return $paths;
    }
    
}

