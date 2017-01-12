<?php
/**
 * User: Raaghu
 * Date: 25-09-2015
 * Time: AM 11:57
 */

namespace PHPPlatform\tests\Mock\Config;

use Composer\Autoload\ClassLoader;
use PhpPlatform\Config\SettingsCache;
use PhpPlatform\Mock\Config\MockSettings;
use PhpPlatform\Config\Settings;

class TestMockSettings extends \PHPUnit_Framework_TestCase{
	
	static $thisPackageName = 'php-platform/mock-config';
	
    public function testSetSettings(){
    	// prepare data
    	$classLoaderReflection = new \ReflectionClass(new ClassLoader());
    	$vendorDir = dirname(dirname($classLoaderReflection->getFileName()));
    	$thisPackageConfigFile = dirname($vendorDir).'/config.json';
    	 
    	SettingsCache::getInstance()->reset();
    	
    	$setting = array("test"=>array("my"=>array("settings"=>array(1,array("here"=>"as a array"),3))));
    	file_put_contents($thisPackageConfigFile, json_encode($setting));
    	
    	$actualSetting = Settings::getSettings(self::$thisPackageName);
    	$this->assertEquals($setting,$actualSetting);
    	// prepare data -end
    	
    	MockSettings::setSettings(self::$thisPackageName, "test.my.settings[0]", array("mockhere"=>"as a array"));

    	$actualSetting = Settings::getSettings(self::$thisPackageName,"test.my.settings[0]");
    	$this->assertEquals(array("mockhere"=>"as a array"),$actualSetting);
    	
    	SettingsCache::getInstance()->reset();
    	$actualSetting = Settings::getSettings(self::$thisPackageName);
    	$this->assertEquals($setting,$actualSetting);
    	
    	MockSettings::setSettings(self::$thisPackageName, "test.my.newsettings", array("mockhere1"=>"as a array"));
    	$actualSetting = Settings::getSettings(self::$thisPackageName,"test.my.newsettings");
    	$this->assertEquals(array("mockhere1"=>"as a array"),$actualSetting);
    	 
    	
    	// clear data
    	unlink($thisPackageConfigFile);
    }
    
    
}