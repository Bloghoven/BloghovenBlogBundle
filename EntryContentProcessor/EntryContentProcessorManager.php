<?php

namespace Bloghoven\Bundle\BlogBundle\EntryContentProcessor;

use Symfony\Component\Stopwatch\Stopwatch;

/**
* @author Magnus Nordlander
*/
class EntryContentProcessorManager
{
  use \Bloghoven\Bundle\BlogBundle\Tools\StopwatchableTrait;

  protected $processors = array();

  public function addProcessor(EntryContentProcessorInterface $processor, $format_group = 'html', $priority = 0)
  {
    if (!isset($this->processors[$format_group]))
    {
      $this->processors[$format_group] = array();
    }

    if (!isset($this->processors[$format_group][$priority]))
    {
      $this->processors[$format_group][$priority] = array();
    }

    $this->processors[$format_group][$priority][] = $processor;
  }

  public function processContent($content, $format_group)
  {
    $stopwatch_outer_event = "Bloghoven: Processing entry content";

    $this->usingStopWatch(function($stopwatch) use ($stopwatch_outer_event)
    {
      $stopwatch->start($stopwatch_outer_event, 'bloghoven');
    });

    krsort($this->processors[$format_group]);
    foreach ($this->processors[$format_group] as $priority => $processors)
    {
      foreach ($processors as $processor)
      {
        $stopwatch_inner_event = sprintf("Bloghoven processing entry content with %s processor", get_class($processor));
        $this->usingStopWatch(function($stopwatch) use ($stopwatch_inner_event)
        {
          $stopwatch->start($stopwatch_inner_event, 'bloghoven');
        });

        $content = $processor->processContent($content, $format_group);

        $this->usingStopWatch(function($stopwatch) use ($stopwatch_inner_event)
        {
          $stopwatch->stop($stopwatch_inner_event, 'bloghoven');
        });
      }
    }

    $this->usingStopWatch(function($stopwatch) use ($stopwatch_outer_event)
    {
      $stopwatch->stop($stopwatch_outer_event, 'bloghoven');
    });

    return $content;
  }
}