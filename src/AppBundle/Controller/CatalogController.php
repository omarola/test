<?php

namespace AppBundle\Controller;

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

    public function getAllItemAction()
    {
        $content = $this->getDoctrine()->getRepository('AppBundle:Item')->findAll();
        if ($content === NULL) {

            return new View("Items not found", Response::HTTP_NOT_FOUND);
        } else
            return new View($content,Response::HTTP_OK);
    }

    public function getItemAction(Request $request)
    {

        return new View("",Response::HTTP_OK);
    }

    public function postItemAction(Request $request)
    {

        return new View("",Response::HTTP_OK);
    }
}