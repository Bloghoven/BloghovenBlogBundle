<?php

namespace Bloghoven\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Bloghoven\Bundle\BlogBundle\ContentProvider\Interfaces\CachableContentProviderInterface;

/**
* 
*/
class HomeController extends Controller
{
  public function homeAction(Request $request, $_format = 'html')
  {
    $provider = $this->get('bloghoven.content_provider');

    $response = new Response();

    if ($provider instanceOf CachableContentProviderInterface)
    {
      $response->setPublic();
      $response->setLastModified($provider->getLastModificationTime());

      if ($response->isNotModified($request)) {
        return $response;
      }
    }

    $pagerfanta = $provider->getHomeEntriesPager();

    $pagerfanta->setMaxPerPage($this->get('bloghoven.settings')->get('per_page'));
    $pagerfanta->setCurrentPage($request->query->get('page', 1));

    if ($_format == 'html')
    {
      return $this->render('BloghovenAbstractThemeBundle:Home:home.html.twig', array('pager' => $pagerfanta), $response);
    }
    else
    {
      return $this->render("BloghovenBlogBundle:Feed:feed.$_format.twig", array('pager' => $pagerfanta), $response);
    }
  }
}