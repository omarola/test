<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;
use FOS\RestBundle\View\View;

class CatalogController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function getAllCategoryAction(Request $request)
    {
        $name = $request->query->get('name');

        $result = $this->getDoctrine()->getRepository('AppBundle:Category')->findBy(array('name' => $name));

        if ($result === NULL) {

            return new View("Catalog not found", Response::HTTP_NOT_FOUND);
        } else
            return new View($result,Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return View|object
     */
    public function getCategoryAction($id)
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        if (!$result instanceof Category) {

            return new View("ID: " . $id . " not found", Response::HTTP_NOT_FOUND);
        }

        return new View($result, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return View|Response
     */
    public function postCategoryAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $content = $request->getContent();

        $category = $serializer->deserialize($content,'AppBundle\Entity\Category','json');

        $errors = $this->get('validator')->validate($category);

        if (count($errors) > 0) {
            return new View("NAME LENGTH MUST BE >4",Response::HTTP_BAD_REQUEST);
        } else {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new View($category, Response::HTTP_OK);
        }
    }

    /**
     * @return View
     */
    public function getAllItemsAction()
    {
        $content = $this->getDoctrine()->getRepository('AppBundle:Item')->findAll();
        if ($content === NULL) {

            return new View("Items not found", Response::HTTP_NOT_FOUND);
        } else
            return new View($content,Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return View
     */
    public function getItemAction($id)
    {
            $content = $this->getDoctrine()->getRepository('AppBundle:Item')->find($id);
            if (!$content instanceof Item) {

                return new View("ID: " . $id . " not found. This item does not exist", Response::HTTP_NOT_FOUND);
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

        $item = $serializer->deserialize($content,'AppBundle\Entity\Item','json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        return new View($item,Response::HTTP_OK);
    }
}