<?php

namespace Bloghoven\Bundle\BlogBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TaggedEntryContentProcessorPass implements CompilerPassInterface
{
  /**
   * @see Symfony\Component\DependencyInjection\Compiler.CompilerPassInterface::process()
   */
  public function process(ContainerBuilder $container)
  {
    if (!$container->hasDefinition('bloghoven.entry_content_processor_manager')) {
      return;
    }

    $manager_def = $container->getDefinition('bloghoven.entry_content_processor_manager');

    $tags = $container->findTaggedServiceIds('bloghoven.entry_content_processor');

    foreach ($tags as $service_id => $tag)
    {
      $manager_def->addMethodCall('addProcessor', array(new Reference($service_id), $tag[0]['format'], $tag[0]['priority']));
    }
  }
}