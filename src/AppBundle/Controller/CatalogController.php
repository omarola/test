<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;

/**
 * Class CatalogController
 * @package AppBundle\Controller
 */
class CatalogController extends FOSRestController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getAllCategoryAction(Request $request)
    {
        $name = $request->query->get('name');

        $content = $this->getDoctrine()->getRepository(Category::class)->findByName($name);

        if ($content === NULL) {
            return new Response("Catalog not found", Response::HTTP_NOT_FOUND);
        }

        return new Response($this->serialize($content), Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return Response
     */
    public function getCategoryAction($id)
    {
        $content = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (!$content instanceof Category) {
            return new Response("ID: {$id} not found", Response::HTTP_NOT_FOUND);
        }

        return new Response($this->serialize($content), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCategoryAction(Request $request)
    {
        $category = $this->deserialize($request->getContent());

        $errors = $this->get('validator')->validate($category);

        if (count($errors) > 0) {
            return new Response($this->serialize($errors), Response::HTTP_NO_CONTENT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return new Response('DONE!', Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateCategoryAction(Request $request)
    {
        $category = $this->deserialize($request->getContent());

        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Category::class)->findById($category);
        $em->merge($category);
        $em->flush();

        return new Response('Update was successful!', Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return Response
     */
    public function deleteCategoryAction($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (empty($category)) {
            return new Response("Category not found", Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return new Response("Deleted successfully", Response::HTTP_OK);
    }

    /**
     * @param $data
     * @return array|\JMS\Serializer\scalar|mixed|object
     */
    private function deserialize($data)
    {
        $serializer = $this->get('jms_serializer');

        $result = $serializer->deserialize($data, Category::class, 'json');

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