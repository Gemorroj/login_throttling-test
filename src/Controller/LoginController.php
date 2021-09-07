<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", methods={"POST"}, defaults={"_format": "json"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        return $this->json($request->request->all());
    }
}
