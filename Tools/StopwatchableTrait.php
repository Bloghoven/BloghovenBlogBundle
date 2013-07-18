<?php

namespace Bloghoven\Bundle\BlogBundle\Tools;

use Symfony\Component\Stopwatch\Stopwatch;

trait StopwatchableTrait
{
    protected $stopwatch = null;

    public function setStopwatch(Stopwatch $stopwatch = null)
    {
        $this->stopwatch = $stopwatch;
    }

    protected function usingStopwatch($callable)
    {
        if ($this->stopwatch)
        {
            $callable($this->stopwatch);
        }
    }
}