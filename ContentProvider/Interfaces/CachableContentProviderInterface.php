<?php

namespace Bloghoven\Bundle\BlogBundle\ContentProvider\Interfaces;

interface CachableContentProviderInterface extends ContentProviderInterface
{
  /**
   * @return DateTime
   */
  public function getLastModificationTime();
}