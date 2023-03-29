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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[Route('/job')]

class JobController extends AbstractController
{

    #[Route('/createjob/', name: 'job_create', methods: ['POST']) ]
    public function create(JobRepository $jobRepository, UserRepository $userRepository, Request $request): Response
    {

        $params = json_decode($request->getContent(), true);
        $missing_param = [];
        $req_params = ["name","intern"];

        if ( $request->headers->has('Authorization') ) {
            $token = str_replace("Bearer ", "", $request->headers->get('Authorization'));
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
            if ( !isset($params[$param]) || $params[$param] === "" ) {
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

    #[Route('/list/', name: 'job_list', methods: ['GET']) ]
    public function list(JobRepository $jobRepository, UserRepository $userRepository, Request $request): Response
    {
     
        if ( $request->headers->has('Authorization') ) {
            $token = str_replace("Bearer ", "", $request->headers->get('Authorization'));
        } else {
            $token = false;
        }

        if ( $token ) {
            $user = $userRepository->findOneByToken($token);

            if ( is_null($user) ) {
                $resp = array(
                    "message" => "The provided token is incorrect."
                );

                return new JsonResponse($resp, 403);
            }
        }

        if ( $token && in_array("ROLE_ADMIN", $user->getRoles()) ) {

            $list_jobs = $jobRepository->findAll();

        } else {
            $list_jobs = $jobRepository->findByIntern(false);
        }

        $json_tab = [];

        foreach ($list_jobs as $job) {
            $json_tab[] = array(
                "id"=>$job->getId(),
                "name"=>$job->getName(),
                "intern"=>$job->isIntern()
            );
        }

        $resp = array(
            "message" => "List provided with success.",
            "jobsList" => $json_tab 
        );

        return new JsonResponse($resp, 200);

    }

}