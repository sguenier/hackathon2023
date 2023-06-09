<?php

namespace App\Controller\Back;

use App\Entity\Exercice;
use App\Entity\User;
use App\Repository\ExerciceRepository;
use App\Repository\UserRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/exercice')]
class ExerciceController extends AbstractController
{

    #[Route('s/', name: 'app_exercice_index', methods: ['GET'])]
    public function index(ExerciceRepository $exerciceRepository,TagRepository $tagRepository, SerializerInterface $serializer): Response
    {

        $filter = $_GET['filter'] ?? null;

        if($filter != null) {
            $tag = $tagRepository->findOneBy(['id' => $filter]);
            if($tag == null) {
                $json = $serializer->serialize($postRepository->findAll(), 'json', [
                    // dont return the posts of the id, so it doesnt loop
                    'ignored_attributes' => ['exercices'],
                    'circular_reference_handler' => function ($object) {
                        return $object->getId();
                    }   
                ]);
                return new Response($json, 200, ['Content-Type' => 'application/json']);
            }
            $exercices = $tag->getExercices();
            $json = $serializer->serialize($exercices, 'json', [
                // dont return the posts of the id, so it doesnt loop
                'ignored_attributes' => ['exercices'],
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }   
            ]);
            return new Response($json, 200, ['Content-Type' => 'application/json']);
        }

        // return json response
        $json = $serializer->serialize($exerciceRepository->findAll(), 'json', [
            // dont return the posts of the id, so it doesnt loop
            'ignored_attributes' => ['exercices','author','posts'],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }   
        ]);
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/create/', name: 'app_exercice_create', methods: ['POST'])]
    public function create(Request $request, UserRepository $userRepository, ExerciceRepository $exerciceRepository, TagRepository $tagRepository): Response
    {

        $req_params = ["name","duration","description"];
        $missing_param = [];

        if (!$request->headers->has('Authorization')) {
            return new JsonResponse(['error' => 'Missing authorization header'], 400);
        }else{
            $token = $request->headers->get('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $user = $userRepository->findOneBy(['session_token' => $token]);
            if($user == null) {
                return new JsonResponse(['error' => 'Invalid token'], 400);
            }
        }

        if ( !in_array("ROLE_ADMIN", $user->getRoles()) ) {
            return new JsonResponse(['message' => 'You don\'t have permission to create exercice.'], 403);
        }

        $exo = new Exercice();

        $image = $request->files->get('cover');
        if ( !is_null($image) ) {
            $imageSize = $image->getSize();
            $imageType = $image->getMimeType();
            if($imageSize > 8000000) {
                return new JsonResponse(['error' => 'Image too big'], 400);
            }
            if($imageType != 'image/jpeg' && $imageType != 'image/png') {
                return new JsonResponse(['error' => 'Invalid image type'], 400);
            }

            $imageName = md5(uniqid()) . '.' . $image->guessExtension();

            $image->move(
                $this->getParameter('exercices_directory'),
                $imageName
            );

            if(!file_exists($this->getParameter('exercices_directory') . '/' . $imageName)) {
                return new JsonResponse(['error' => 'Image not saved'], 400);
            }else{
                  // remove the old image
                if(!is_null($exo->getCover()) && file_exists($this->getParameter('exercices_directory') . '/' . $exo->getCover())) {
                    unlink($this->getParameter('exercices_directory') . '/' . $exo->getCover());
                }
            }

            $exo->setCover($imageName);
        }

        $jsonParam = json_decode($request->getContent(), true);

        foreach ($req_params as $param) {
            if ( is_null($jsonParam[$param]) || $jsonParam[$param] == "" ) {
                $missing_param[] = $param;
            }
        }

        if ( count($missing_param) > 0 ) {
            $resp = array(
                "message"=>"Parameters are missing.",
                "missing_param"=>$missing_param
            );
    
            return new JsonResponse($resp, 400);
        }

        $exo = new Exercice();
        $exo->setName($jsonParam['name']);
        $exo->setDuration($jsonParam['duration']);
        $exo->setEquipment($jsonParam['equipment']);
        $exo->setDescription($jsonParam['description']);
        $exo->setAuthor($user);


        $video_id = null;

        if ( !is_null($jsonParam['urlyoutube']) && preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w\-]{11})(?:[\&\?].*)?$/', $jsonParam['urlyoutube'], $matches)) {
            $video_id = $matches[1];
        }
        $exo->setUrlyoutube($video_id);

        if ( !is_null($jsonParam['tags']) ) {
            $tmp_tags = json_decode($jsonParam['tags']);

            foreach ($tmp_tags as $tag) {
                $tmp_tag = $tagRepository->find($tag);

                if ( is_null($tmp_tag) ) {
                    $resp = array(
                        "message"=>"One of the provided tags doesn't exist."
                    );
            
                    return new JsonResponse($resp, 404);
                } else {
                    $exo->addTag($tmp_tag);
                }
            }
        }

        $exerciceRepository->save($exo, true);

        $resp = array(
            "message"=>"The exercice has been created with success."
        );

        return new JsonResponse($resp, 200);


    }

    #[Route('/{id}/', name: 'app_exercice_show', methods: ['GET'])]
    public function show(Exercice $exercice): Response
    {

        $tabExo = $this->exerciceToArray($exercice);
        $resp = array(
            "message"=>"Exercice found with success.",
            "exercice"=>$tabExo
        );

        return new JsonResponse($resp, 200);

    }

    #[Route('/{id}/', name: 'app_exercice_update', methods: ['POST'])]
    public function update(Request $request, Exercice $exo, UserRepository $userRepository, TagRepository $tagRepository, ExerciceRepository $exerciceRepository): Response
    {

        if (!$request->headers->has('Authorization')) {
            return new JsonResponse(['message' => 'Missing authorization header'], 400);
        }else{
            $token = $request->headers->get('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $user = $userRepository->findOneBy(['session_token' => $token]);
            if($user == null) {
                return new JsonResponse(['mesage' => 'Invalid token'], 400);
            }
        }

        if ( $user->getId() != $exo->getAuthor()->getId() ) {
            return new JsonResponse(['message' => 'You dont\'t have permission to edit this exercice'], 403);
        }

        $image = $request->files->get('cover');
        if ( !is_null($image) ) {
            $imageSize = $image->getSize();
            $imageType = $image->getMimeType();
            if($imageSize > 8000000) {
                return new JsonResponse(['error' => 'Image too big'], 400);
            }
            if($imageType != 'image/jpeg' && $imageType != 'image/png') {
                return new JsonResponse(['error' => 'Invalid image type'], 400);
            }

            $imageName = md5(uniqid()) . '.' . $image->guessExtension();

            $image->move(
                $this->getParameter('exercices_directory'),
                $imageName
            );

            if(!file_exists($this->getParameter('exercices_directory') . '/' . $imageName)) {
                return new JsonResponse(['error' => 'Image not saved'], 400);
            }else{
                  // remove the old image
                if(!is_null($exo->getCover()) && file_exists($this->getParameter('exercices_directory') . '/' . $exo->getCover())) {
                    unlink($this->getParameter('exercices_directory') . '/' . $exo->getCover());
                }
            }

            $exo->setCover($imageName);
        }


        if ( !is_null($request->get('name')) ) {
            $exo->setName($request->get('name'));
        }

        if ( !is_null($request->get('duration')) ) {
            $exo->setDuration($request->get('duration'));
        }

        if ( !is_null($request->get('equipment')) ) {
            $exo->setEquipment($request->get('equipment'));
        }

        if ( !is_null($request->get('description')) ) {
            $exo->setDescription($request->get('description'));
        }

        if ( !is_null($request->get('urlyoutube')) ) {
            $exo->setUrlyoutube($request->get('urlyoutube'));
        }

        if ( !is_null($request->get('tags')) ) {
            $already_tags = $user->getTags();

            foreach ($already_tags as $tmptag) {
                $user->removeTag($tmptag);
            }

            $tmp_tags = json_decode($request->get('tags'), true);

            foreach ($tmp_tags as $tag) {
                $tmp = $tagRepository->find($tag);

                if ( is_null($tag) ) {
                    return new JsonResponse(['message' => 'One of the provided tag is incorrect'], 404);
                }

                $exo->addTag($tmp);
            }
        }

        $exerciceRepository->save($exo, true);
        $exoTab = $this->exerciceToArray($exo);
        $resp = array(
            "message"=>"The exercice has been created with success.",
            "exercice"=>$exoTab
        );

        return new JsonResponse($resp, 200);


    }



    public function exerciceToArray(Exercice $exercice)
    {

        $tags = array();

        foreach ($exercice->getTags() as $tag) {
            $tmp = array(
                "id"=>$tag->getId(),
                "name"=>$tag->getName()
            );
            $tags[] = $tmp;
        }

        $exoTab = array(
            "name"=>$exercice->getName(),
            "duration"=>$exercice->getDuration(),
            "equipment"=>$exercice->getEquipment(),
            "description"=>$exercice->getDescription(),
            "urlyoutube"=>$exercice->getUrlyoutube(),
            "cover"=>$exercice->getCover(),
            "Tag"=>$tags,
            "author"=>$exercice->getAuthor()->getId()
        );

        return $exoTab;

    }



}