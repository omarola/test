<?php

namespace AppBundle\Controller;

use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Collections\ArrayCollection;

class CatalogController extends FOSRestController
{
    /**
     * @return array|View
     */
    public function getAllAction()
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        if ($result === NULL) {

            return new View("Catalog not found", Response::HTTP_NOT_FOUND);
        }
        return new View($result,Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return View|object
     */
    public function getAction($id)
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        if (!$result instanceof Category) {

            return new View("ID: " . $id . " not found", Response::HTTP_NOT_FOUND);
        }

        return new View($result, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $array = [];

        if($content = $request->getContent()) {

            $array = json_decode($content, true);

        }

        if(!$this->checkLength($array['name'])) {

            return new View("NAME LENGHT MUST BE >4",Response::HTTP_CONFLICT);

        } else {

            /**
             * @var Category $parent
             */
            $parent = $this->getDoctrine()->getRepository('AppBundle:Category')->find($array['parentId']);

            $category = new Category();

            $category->setName($array['name']);

            $category->setParent($parent);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new View($category, Response::HTTP_OK);
        }
    }

    /**
     * @param $data
     * @param int $min
     * @return bool
     */
    private function checkLength($data, $min = 4)
    {
        if(mb_strlen($data)<$min) {
            return false;
        } else
            return true;
    }
}