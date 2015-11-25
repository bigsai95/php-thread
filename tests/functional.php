<?php
/**
 *  Funtional test
 */
require_once(dirname(__DIR__).'/vendor/autoload.php');
class MyFork extends Aban\Thread\Forker {
    public function onStart($pid)
    {
        echo "$pid start\n";
    }
    public function onExit($pid, $status)
    {
        echo "$pid stop\n";
    }
}
$threadsCount = (int) $argv[1];
$p = new MyFork();
for ($thread = 0; $thread < $threadsCount; $thread++) {
    $p->add(array($thread));
}
$p->run(function(){$pid = getmypid(); echo "$pid payload\n";});
echo "OK\n";