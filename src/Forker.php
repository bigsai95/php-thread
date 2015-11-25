<?php namespace Aban\Thread;

class Forker
{
    protected $works = array();

    /**
     * add work
     *
     * @param array $work
     * @return void
     */
    public function add( array $work)
    {
        $this->works[] = $work;
    }

    /**
     * run a callback in parrallel thread
     *
     * @param callable $callback
     * @return void
     */
    public function run(\Closure $callback = null)
    {
        $callback = $callback ?: function () {};

        $children = array();
        while ( ! empty($this->works)) {
            $items = array_pop($this->works);
            $pid = pcntl_fork();
            if (-1 == $pid) {
                throw new \RuntimeException('無法使用子程序!');
            } elseif ($pid) {
                //子程序start
                $children[] = $pid;
                $this->onStart($pid);
            } else {
                try {
                    //子程序處理 callback
                    $callback($items);
                    exit(0);
                } catch (\Exception $e) {
                    exit($e->getCode());
                }
            }
        }

        if ($children) {
            foreach ($children as $child) {
                $res = pcntl_waitpid($child, $status);
                if ($res == -1 || $res > 0) {
                    //子程序end
                    $status = pcntl_wexitstatus($status);
                    $this->onExit($child, $status);
                }
            }
        }
    }

    /**
     * on thread start
     *
     * @param int $pid Process ID
     * @return void
     */
    protected function onStart($pid)
    {
        echo "Child $pid start\n";
    }

    /**
     * on thread exit
     *
     * @param int $pid      Process ID
     * @param int $status   Exit status
     * @return void
     */
    protected function onExit($pid, $status)
    {
        echo "Child $pid $status stop\n";
    }
}
