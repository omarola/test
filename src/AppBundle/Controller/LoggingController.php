<?php
namespace AppBundle\Controller;
use AppBundle\Entity\ChangeLog;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoggingController
 * @package AppBundle\Controller
 */
class LoggingController extends FOSRestController
{
    /**
     * @return Response
     */
    public function getLogAction()
    {
        $content = $this->getDoctrine()->getRepository(ChangeLog::class)->findAll();

        if ($content === NULL) {
            return new Response("Log not found", Response::HTTP_NOT_FOUND);
        }

        return new Response ($this->serialize($content), Response::HTTP_OK);
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