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

        $result = $this->getDoctrine()->getRepository(Category::class)->findBy(array('name' => $name));

        if ($result === NULL) {
            return new View("Catalog not found", Response::HTTP_NOT_FOUND);
        }

        return new View($result,Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return View|object
     */
    public function getCategoryAction($id)
    {
        $result = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (!$result instanceof Category) {

            return new View("ID: {$id} not found", Response::HTTP_NOT_FOUND);
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

        $category = $serializer->deserialize($content,Category::class,'json');

        $errors = $this->get('validator')->validate($category);

        if (count($errors) > 0) {
            return new View($errors,Response::HTTP_NO_CONTENT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return new View($category, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @param Request $request
     * @return View
     */
    public function updateCategoryAction($id,Request $request)
    {
        $content = $request->getContent();

        $category= $this->deserialize($content);

        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Category::class)->findById($category);
        $em->merge($category);
        $em->flush();

        return new View("updated!",Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return View
     */
    public function deleteCategoryAction($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (empty($category)) {
            return new View("Category not found", Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return new View("deleted successfully", Response::HTTP_OK);
    }

    /**
     * @param $data
     * @return array|\JMS\Serializer\scalar|mixed|object
     */
    private function deserialize($data)
    {
        $serializer = $this->get('jms_serializer');

        $result = $serializer->deserialize($data,Category::class,'json');

       return $result;
    }
}