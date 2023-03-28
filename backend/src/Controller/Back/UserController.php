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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/user')]

class UserController extends AbstractController
{

    #[Route('/index', name: 'user_index', methods: ['GET']) ]
    public function index(UserRepository $userRepository, Request $request): Response
    {

        return $this->render('Back/user/index.html.twig');

    }

    #[Route('/createuser', name: 'user_create', methods: ['POST']) ]
    public function create(UserRepository $userRepository, JobRepository $jobRepository, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $params = json_decode($request->getContent(), true);

        $req_params = ["pwd","pwdconfirm","socialsecuritynumber","email","firstname","lastname","job"];

        $missing_param = array();

        foreach ($req_params as $param) {
            if ( empty($params[$param]) ) {
                $missing_param[] = $param;
            }
        }

        //cas ou l'user n'existe pas on le crée
        if ( count($missing_param) == 0 && is_null($userRepository->findOneByEmail($params['email'])) ) {
            if ( $params['pwd'] == $params['pwdconfirm'] ) {
                $user = new User();

                $pwd = $passwordHasher->hashPassword($user, $params['pwd']);

                $user->setEmail($params['email']);
                $user->setPassword($pwd);
                $user->setLastname($params['lastname']);
                $user->setFirstname($params['firstname']);

                $job = $jobRepository->findOneById($idjob);

                if ( is_null($job) ) {
                    $resp = array(
                        "message" => "The Job provided is not in the list."
                    );

                    return new JsonResponse($resp, 400);
                }

                $user->setJob($params['job']);
                $user->setSocialSecurityNumber($params['socialsecuritynumber']);

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

        } elseif ( count($missing_param) > 0 ) {
            $resp = array(
                "message"=>"Parameters are missing.",
                "missing_param"=>$missing_param
            );
    
            return new JsonResponse($resp, 400);
        } elseif ( !is_null($userRepository->findOneByEmail($params['email'])) ) {
            $resp = array(
                "message"=>"A user with the same email already exists."
            );
    
            return new JsonResponse($resp, 409);
        }

    }

    #[Route('/login', name: 'user_login', methods: ['POST']) ]
    public function login(UserRepository $userRepository, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $params = json_decode($request->getContent(), true);

        $email = $params['email'];
        $pwd = $params['pwd'];

        $users = $userRepository->findByEmail($email);

        if ( count($users) > 0 ) {
            $user = $users[0];

            if ($passwordHasher->isPasswordValid($user, $pwd)) {
                $token = $this->generateToken();

                $user->setSessionToken($token);

                $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $user->setDateSessionToken($date);

                $userRepository->save($user, true);

                $resp = array(
                    "token" => $token,
                    "message" => "Connected with success."
                );

                return new JsonResponse($resp, 200);
            }
        } else {
            $resp = array(
                "message" => "User provided doesn't exist."
            );

            return new JsonResponse($resp, 400);
        }

    }

    #[Route('/profile', name: 'user_profile', methods: ['POST']) ]
    public function profile(UserRepository $userRepository, Request $request, UserPasswordHasherInterface $passwordHasher, SerializerInterface $serializer): Response
    {

        $params = json_decode($request->getContent(), true);
        $req_params = ["idUser","token"];
        $missing_param = array();

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

        $user = $userRepository->findOneById($params['idUser']);

        if ( is_null($user) ) {
            $resp = array(
                "message" => "The user doesn't exists."
            );

            return new JsonResponse($resp, 404);
        }

        if ( $user->getSessionToken() == $params['token'] ) {

            $tabUser = array(
                "email"=>$user->getEmail(),
                "role"=>$user->getRoles(),
                "lastname"=>$user->getLastname(),
                "firstname"=>$user->getFirstname(),
                "job"=>["id"=>$user->getJob()->getId(),"name"=>$user->getJob()->getName()],
                "socialSecurityNumber"=>$user->getSocialSecurityNumber()
            );

            $resp = array(
                "message" => "The token provided is incorrect.",
                "user" => $tabUser
            );

            return new JsonResponse($resp, 200);
            
        } else {
            $resp = array(
                "message" => "The token provided is incorrect."
            );

            return new JsonResponse($resp, 403);
        }
    }

    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

}