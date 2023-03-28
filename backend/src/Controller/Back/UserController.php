<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Entity\Job;
use App\Repository\UserRepository;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/user')]

class UserController extends AbstractController
{

    #[Route('/index', name: 'user_index', methods: ['GET']) ]
    public function index(UserRepository $userRepository, Request $request): Response
    {

        return $this->render('Back/user/index.html.twig');

    }

    #[Route('/createuser', name: 'user_create', methods: ['POST']) ]
    public function create(UserRepository $userRepository, JobRepository $jobRepository, Request $request): Response
    {

        // $params = json_decode($request->getContent(), true);
        $params = json_decode($request->getContent(), true);

        $missing_param = array();

        if ( $email['email'] != "" ) {
            $email = $params['email'];
        }
        $firstname = $params['firstname'];
        $lastname = $params['lastname'];
        $socialsecuritynumber = $params['socialsecuritynumber'];
        $idjob = $params['job'];

        $pwd = $params['pwd'];
        $pwdconfirm = $params['pwdconfirm'];

        $test_user = $userRepository->findByEmail($email);

        //cas ou l'user n'existe pas on le crée
        if ( count($test_user) == 0 ) {
            if ( $pwd == $pwdconfirm ) {
                $user = new User();

                $user->setEmail($email);
                $user->setPassword($pwd);
                $user->setLastname($lastname);
                $user->setFirstname($firstname);

                $job = $jobRepository->findOneById(3);

                if ( is_null($job) ) {
                    $resp = array(
                        "message" => "The Job provided is not in the list."
                    );

                    return new JsonResponse($resp, 400);
                }

                $user->setJob($job);
                $user->setSocialSecurityNumber($socialsecuritynumber);

                $userRepository->save($user, true);

                $resp = array(
                    "message"=>"User created with success."
                );

                return new JsonResponse($resp, 201);
            } else {
                $resp = array(
                    "message"=>"The password and its confirmation don't match."
                );

                return new JsonResponse($resp, 400);
            }

        }

        $resp = array(
            "message"=>"A user with the same email already exists."
        );

        return new JsonResponse($resp, 409);

    }

}