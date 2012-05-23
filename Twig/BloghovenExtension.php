<?php

namespace Bloghoven\Bundle\BlogBundle\Twig;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
* @author Magnus Nordlander
*/
class BloghovenExtension extends \Twig_Extension
{
  protected $settings;

  public function __construct(ParameterBag $settings)
  {
    $this->settings = $settings;
  }

  public function getFunctions()
  {
    return array(
      'bloghoven_setting' => new \Twig_Function_Method($this, 'getSetting'),
    );
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