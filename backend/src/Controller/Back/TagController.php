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
    #[Route('/', name: 'app_tag_index', methods: ['GET'])]
    public function index(TagRepository $tagRepository): Response
    {
        return $this->json($tagRepository->findAll());

    }

    #[Route('/new/', name: 'app_tag_new', methods: ['POST'])]
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
            $token = str_replace('Basic ', '', $token);
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
       $jsonedTag = $this->json($tag);
    }

    #[Route('/{id}/edit', name: 'app_tag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tag $tag, TagRepository $tagRepository): Response
    {
      
    }

    #[Route('/{id}', name: 'app_tag_delete', methods: ['POST'])]
    public function delete(Request $request, Tag $tag, TagRepository $tagRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->request->get('_token'))) {
            $tagRepository->remove($tag, true);
        }

        return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}
