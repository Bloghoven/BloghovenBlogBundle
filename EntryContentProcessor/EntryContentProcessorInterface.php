<?php

namespace Bloghoven\Bundle\BlogBundle\EntryContentProcessor;

interface EntryContentProcessorInterface
{
  /**
   * @param string $content The partially processed entry content. Potentially unsafe data, so never eval it in any way.
   * @return string The content after your processor is done processing it.
   */
  public function processContent($content, $format);
}