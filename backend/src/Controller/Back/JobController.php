<?php

namespace App\Controller\Back;

use App\Entity\Job;
use App\Entity\User;
use App\Repository\JobRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/job')]

class JobController extends AbstractController
{

    #[Route('/createjob/', name: 'job_create', methods: ['POST']) ]
    public function create(JobRepository $jobRepository, UserRepository $userRepository, Request $request): Response
    {

        $params = json_decode($request->getContent(), true);
        $missing_param = [];
        $req_params = ["name","intern"];

        if ( isset($request->headers->all()['authorization'][0]) ) {
            $token = str_replace("Basic ", "", $request->headers->all()['authorization'][0]);
        } else {
            $resp = array(
                "message" => "The authentification token is missing ffrom the headers."
            );

            return new JsonResponse($resp, 400);
        }

        if ( is_null($userRepository->findOneByToken($token)) ) {
            $resp = array(
                "message" => "The provided token is incorrect."
            );

            return new JsonResponse($resp, 403);
        }

        foreach ($req_params as $param) {
            if ( empty($params[$param]) ) {
                $missing_param[] = $param;
            }
        }

        if ( count($missing_param) > 0 ) {
            $resp = array(
                "message" => "The user doesn't exists.",
                "missing_param" => $missing_param
            );

            return new JsonResponse($resp, 400);
        }

        if ( is_null($jobRepository->findOneByName($params['name'])) ) {
            $job = new Job();
            $job->setName($params['name']);
            $job->setIntern($params['intern']);

            $jobRepository->save($job, true);

            $resp = array(
                "message"=>"Job created with success."
            );

            return new JsonResponse($resp, 201);
        } else {
            $resp = array(
                "message" => "A job with the same name already exists."
            );

            return new JsonResponse($resp, 409);
        }      

    }

}