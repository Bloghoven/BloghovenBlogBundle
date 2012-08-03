<?php

namespace Bloghoven\Bundle\BlogBundle\Twig;

use Symfony\Component\HttpFoundation\ParameterBag;
use Bloghoven\Bundle\BlogBundle\EntryContentProcessor\EntryContentProcessorManager;

/**
* @author Magnus Nordlander
*/
class BloghovenExtension extends \Twig_Extension
{
  protected $settings;
  protected $ecpm;

  public function __construct(ParameterBag $settings, EntryContentProcessorManager $ecpm)
  {
    $this->settings = $settings;
    $this->ecpm = $ecpm;
  }

  public function getFunctions()
  {
    return array(
      'bloghoven_setting' => new \Twig_Function_Method($this, 'getSetting'),
    );
  }

  public function getFilters()
  {
    return array(
      'processContent' => new \Twig_Filter_Method($this, 'processContent', array('is_safe' => array('html'))),
    );
  }

  public function processContent($content, $group = 'html')
  {
    return $this->ecpm->processContent($content, $group);
  }

  public function getSetting($name)
  {
    return $this->settings->get($name);
  }

  public function getName()
  {
    return 'bloghoven';
  }
}