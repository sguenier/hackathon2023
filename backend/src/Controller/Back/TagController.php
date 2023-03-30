<?php

namespace App\Controller\Back;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/tag')]
class TagController extends AbstractController
{
    #[Route('s/', name: 'app_tag_index', methods: ['GET'])]
    public function index(TagRepository $tagRepository): Response
    {
        return $this->json($tagRepository->findAll());

    }

    #[Route('/', name: 'app_tag_new', methods: ['POST'])]
    public function new(Request $request, TagRepository $tagRepository, UserRepository $userRepository): Response
    {
      
        $data = json_decode($request->getContent(), true);
        $tag = new Tag();

        if (!isset($data['name'])) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        if(!$request->headers->has('Authorization')) {
            return new JsonResponse(['error' => 'Missing authorization header'], 400);
        }else{
            $token = $request->headers->get('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $user = $userRepository->findOneBy(['session_token' => $token]);
            if($user == null) {
                return new JsonResponse(['error' => 'Invalid token'], 400);
            }
        }

        $tag->setName($data['name']);

        // check if there is a tag with the same name
        $tagExists = $tagRepository->findOneBy(['name' => $tag->getName()]);
        if($tagExists != null) {
            return new JsonResponse(['error' => 'Tag already exists'], 400);
        }

        $tagRepository->save($tag, true);
        if($tag->getId() == null) {
            return new JsonResponse(['error' => 'Tag not created'], 400);
        }else{
            return new JsonResponse(['success' => 'Tag created'], 200);
        }

    }

    #[Route('/{id}/', name: 'app_tag_show', methods: ['GET'])]
    public function show(Tag $tag): Response
    {
       $jsonedTag = [
           'id' => $tag->getId(),
           'name' => $tag->getName(),
       ];
       return new JsonResponse($jsonedTag, 200);
    }

    #[Route('/{id}/', name: 'app_tag_edit', methods: ['PUT'])]
    public function edit(Request $request, Tag $tag, TagRepository $tagRepository, UserRepository $userRepository): Response
    {
       $data = json_decode($request->getContent(), true);

         if (!isset($data['name'])) {
              return new JsonResponse(['error' => 'Missing required fields'], 400);
         }

         if(!$request->headers->has('Authorization')) {
              return new JsonResponse(['error' => 'Missing authorization header'], 400);
            }else{
                $token = $request->headers->get('Authorization');
                $token = str_replace('Bearer ', '', $token);
                $user = $userRepository->findOneBy(['session_token' => $token]);
                if($user == null) {
                    return new JsonResponse(['error' => 'Invalid token'], 400);
                }
            }

            // check if tag with the same name already exists
            $tagExists = $tagRepository->findOneBy(['name' => $data['name']]);
            if($tagExists != null) {
                return new JsonResponse(['error' => 'Tag already exists'], 400);
            }

            $tag->setName($data['name']);
            $tagRepository->save($tag, true);
            if($tag->getId() == null) {
                return new JsonResponse(['error' => 'Tag not updated'], 400);
            }else{
                return new JsonResponse(['success' => 'Tag updated'], 200);
            }

    }

    #[Route('/{id}/', name: 'app_tag_delete', methods: ['DELETE'])]
    public function delete(Request $request, Tag $tag, TagRepository $tagRepository, UserRepository $userRepository): Response
    {
        if(!$request->headers->has('Authorization')) {
            return new JsonResponse(['error' => 'Missing authorization header'], 400);
        }else{
            $token = $request->headers->get('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $user = $userRepository->findOneBy(['session_token' => $token]);
            if($user == null) {
                return new JsonResponse(['error' => 'Invalid token'], 400);
            }

            $tagRepository->remove($tag, true);
            if($tag->getId() != null) {
                return new JsonResponse(['error' => 'Tag not deleted'], 400);
            }else{
                return new JsonResponse(['success' => 'Tag deleted'], 200);
            }
        }

        return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}
