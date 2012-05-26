<?php

namespace Bloghoven\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Bloghoven\Bundle\BlogBundle\ContentProvider\Interfaces\CachableContentProviderInterface;

/**
* 
*/
class CategoryController extends Controller
{
  public function treeAction()
  {
    $roots = $this->get('bloghoven.content_provider')->getCategoryRoots();

    return $this->render('BloghovenAbstractThemeBundle:Category:tree.html.twig', array('roots' => $roots));
  }

  public function entriesAction(Request $request, $permalink_id)
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

    $category = $provider->getCategoryWithPermalinkId($permalink_id);

    $pagerfanta = $provider->getEntriesPagerForCategory($category);

    $pagerfanta->setMaxPerPage($this->get('bloghoven.settings')->get('per_page'));
    $pagerfanta->setCurrentPage($request->query->get('page', 1));

    return $this->render('BloghovenAbstractThemeBundle:Category:entries.html.twig', array('category' => $category, 'pager' => $pagerfanta));
  }
}