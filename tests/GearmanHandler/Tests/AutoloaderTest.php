<?php
namespace GearmanHandler\Tests;

use PHPUnit_Framework_TestCase;
use GearmanHandler\Autoloader;

class AutoloaderTest extends PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        Autoloader::register();
        $this->assertContains(['GearmanHandler\\Autoloader', 'autoload'], spl_autoload_functions());
    }

    public function testAutoload()
    {
        $declared = get_declared_classes();
        $declaredCount = count($declared);
        Autoloader::autoload('Foo');
        $this->assertEquals(
            $declaredCount,
            count(get_declared_classes()),
            'GearmanHandler\\Autoloader::autoload() is trying to load classes outside of the GearmanHandler namespace'
        );
        Autoloader::autoload('GearmanHandler\\Application');
        $this->assertTrue(
            in_array('GearmanHandler\\Application', get_declared_classes()),
            'GearmanHandler\\Autoloader::autoload() failed to autoload the GearmanHandler\\Application class'
        );
    }
}