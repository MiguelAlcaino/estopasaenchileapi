<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\MediaCommiter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaApiController
{
    public function postMedia(Request $request, MediaCommiter $mediaCommiter)
    {
        $mediaUrl    = $request->request->get('mediaUrl');
        $description = $request->request->get('description');

        $response = new JsonResponse();

        if (!empty($mediaUrl) && !empty($description)) {
            $mediaCommiter->addAndCommitMedia($mediaUrl, $description);

            return $response;
        }

        $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        return $response;
    }
}
