<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AttrValue;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ItemController
 * @package AppBundle\Controller
 */
class ItemController extends FOSRestController
{
    /**
     * @return Response
     */
    public function getAllItemsAction()
    {
        $content = $this->getDoctrine()->getRepository(Item::class)->findAll();

        if ($content === NULL) {
            return new Response("Items not found", Response::HTTP_NOT_FOUND);
        }

        return new Response($this->serialize($content), 200);
    }

    /**
     * @param $id
     * @return Response
     */
    public function getItemAction($id)
    {
        $content = $this->getDoctrine()->getRepository(Item::class)->find($id);

        if (!$content instanceof Item) {
            return new Response("ID: {$id} not found. This item does not exist", Response::HTTP_NOT_FOUND);
        }

        return new Response($this->serialize($content), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postItemAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $item = $serializer->deserialize($request->getContent(), AttrValue::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        return new Response("DONE!", Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateItemAction(Request $request)
    {
        $item = $this->deserialize($request->getContent());

        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Item::class)->findById($item);
        $em->persist($item);
        $em->flush();

        return new Response('Update was successful!', Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return Response
     */
    public function deleteItemAction($id)
    {
        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);

        if (empty($item)) {
            return new Response("Item not found", Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        return new Response("Item deleted successfully", Response::HTTP_OK);
    }

    /**
     * @param $data
     * @return array|\JMS\Serializer\scalar|mixed|object
     */
    private function deserialize($data)
    {
        $serializer = $this->get('jms_serializer');

        $result = $serializer->deserialize($data, Item::class, 'json');

        return $result;
    }

    /**
     * @param $data
     * @return mixed|string
     */
    private function serialize($data)
    {
        $serializer = $this->get('jms_serializer');

        $result = $serializer->serialize($data, 'json');

        return $result;
    }
}