<?php

namespace Bloghoven\Bundle\BlogBundle\EntryContentProcessor;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Doctrine\Common\Cache\Cache;

/**
* @author Magnus Nordlander
*/
class MarkdownProcessor implements EntryContentProcessorInterface
{
  /**
   * @var MarkdownParserInterface
   */
  protected $parser;
  protected $cache;

  public function __construct(MarkdownParserInterface $parser = null)
  {
    $this->parser = $parser;
  }

  public function setCache(Cache $cache = null)
  {
    $this->cache = $cache;
  }

  public function processContent($content, $format)
  {
    if ($this->parser && $format == 'html')
    {
      $key = sprintf("%s-%s-%s", get_class($this), $format, md5($content));
      if ($this->cache && $this->cache->contains($key))
      {
        return $this->cache->fetch($key);
      }

      $transformed_content = $this->parser->transform($content);

      if ($this->cache)
      {
        $this->cache->save($key, $transformed_content);
      }

      return $transformed_content;
    }
    return $content;
  }
}