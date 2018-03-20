<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ChangeLog;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class LoggingController
 * @package AppBundle\Controller
 */
class LoggingController extends Controller
{
    /**
     * @return View
     */
    public function getLogAction()
    {
        $content = $this->getDoctrine()->getRepository(ChangeLog::class)->findAll();
        if ($content === NULL) {
            return new View("Log not found", Response::HTTP_NOT_FOUND);
        }

        return new View($content, Response::HTTP_OK);
    }
}