<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class ItemController extends Controller
{
    /**
     * @return View
     */
    public function getAllItemsAction()
    {
        $content = $this->getDoctrine()->getRepository(Item::class)->findAll();
        if ($content === NULL) {

            return new View("Items not found", Response::HTTP_NOT_FOUND);
        }

        return new View($content,Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return View
     */
    public function getItemAction($id)
    {
        $content = $this->getDoctrine()->getRepository(Item::class)->find($id);

        if (!$content instanceof Item) {
            return new View("ID: {$id} not found. This item does not exist", Response::HTTP_NOT_FOUND);
        }

        return new View($content,Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function postItemAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $content = $request->getContent();

        $item = $serializer->deserialize($content,Item::class,'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        return new View($item,Response::HTTP_OK);
    }
}
