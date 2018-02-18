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
    public function listAllAction()
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        if ($result === NULL) {

            return new View("Catalog not found", Response::HTTP_NOT_FOUND);
        }
        return new View($result);
    }

    /**
     * @param $id
     * @return View|object
     */
    public function listByIdAction($id)
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
        if ($result === NULL) {

            return new View("ID: " . $id . " not found", Response::HTTP_NOT_FOUND);
        }

        return new View($result);
    }

    public function postAction(Request $request)
    {
        $array = [];
        if ($content = $request->getContent()) {
            $array = json_decode($content, true);
        }

        $parentId = $this->getDoctrine()->getRepository('AppBundle:Category')->find($array['parentId']);

        $result = new Category();

        $result->setName($array['name']);

        $result->setParent($parentId);

        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();

        return new View("Category Added Successfully", Response::HTTP_OK);

    }

    /**
     * @param $data
     * @return mixed
     */
    private function deserialize($data)
    {
        return $this->container->get('jms-serializer')->deserialize($data, 'json');
    }
}