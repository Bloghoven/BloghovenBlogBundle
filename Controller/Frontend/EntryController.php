<?php

namespace Bloghoven\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Bloghoven\Bundle\BlogBundle\ContentProvider\Interfaces\CachableContentProviderInterface;

/**
* 
*/
class EntryController extends Controller
{
  public function permalinkAction(Request $request, $permalink_id)
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

    $entry = $provider->getEntryWithPermalinkId($permalink_id);

    if (!$entry)
    {
      throw new NotFoundHttpException();
    }

    return $this->render('BloghovenAbstractThemeBundle:Permalink:permalink.html.twig', array('entry' => $entry));
  }
}