<?php

class ForkerTest extends PHPUnit_Framework_TestCase {

    public function testAutoloaded()
    {
        $this->assertTrue(class_exists('\\Aban\\Thread\\Forker'));
    }

    public function testFunctional()
    {
        $count = 25;
        exec('php '.__DIR__."/functional.php $count", $output);
        $this->assertEquals('OK', trim(array_pop($output)));
        $log = array();
        foreach ($output as $line) {
            list($pid, $action) = preg_split('/ /', trim($line));
            $log[$pid][] = $action;
        }
        $this->assertEquals($count, count($log));
        foreach ($log as $actions) {
            sort($actions);
            $this->assertEquals(array('payload', 'start', 'stop'), array_values($actions));
        }
    }

}
