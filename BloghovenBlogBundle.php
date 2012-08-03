<?php

namespace Bloghoven\Bundle\BlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Bloghoven\Bundle\BlogBundle\DependencyInjection\Compiler;

class BloghovenBlogBundle extends Bundle
{
  public function build(ContainerBuilder $container)
  {
    parent::build($container);

    $container->addCompilerPass(new Compiler\TaggedProviderPass());
    $container->addCompilerPass(new Compiler\TaggedEntryContentProcessorPass());
  }
}
