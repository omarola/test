<?php

namespace AppBundle\Controller;

use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;
use FOS\RestBundle\View\View;

class CatalogController extends Controller
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
     * @return View|Response
     */
    public function postAction(Request $request)
    {
        $content = $request->getContent();

        $category = $this->get('jms_serializer')->deserialize($content,'AppBundle\Entity\Category','json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

            return new View($category, Response::HTTP_OK);
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