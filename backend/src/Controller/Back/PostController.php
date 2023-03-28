<?php

namespace App\Controller\Back;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/post')]
class PostController extends AbstractController
{
    //rajouter verif CSRF sur les routes
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        // return json response
        return $this->json($postRepository->findAll());
    }

    #[Route('/new', name: 'app_post_new', methods: ['POST'])]
    public function new(Request $request, PostRepository $postRepository): Response
    {

        // GET json body from the post request
        $data = json_decode($request->getContent(), true);
        $post = new Post();

        // check if the json has the required fields (title, content, author)
        if (!isset($data['title']) || !isset($data['content']) ) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }


        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        // $post->setAuthor($data['author']);   
        $post->setCreatedAt(new \DateTimeImmutable());

        // create the post
        $postRepository->save($post, true);
        if($post->getId() == null) {
            return new JsonResponse(['error' => 'Post not created'], 400);
        }else{  
            return new JsonResponse(['message' => 'Post created'], 201);
        }
        
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        // return json response
        return new JsonResponse($post); 
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['PUT'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    {
       
        $data = json_decode($request->getContent(), true);

        // $form = $this->createForm(PostType::class, $post);
        // $form->submit($data);

        if (!isset($data['title']) || !isset($data['content']) ) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }
        
            $post->setTitle($data['title']);
            $post->setContent($data['content']);

            // $post->setUpdatedAt(new \DateTimeImmutable());
            $postRepository->save($post, true);
            return new JsonResponse(['message' => 'Post updated'], 200);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['DELETE'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);
            return $this->json(['message' => 'Post deleted']);
        }else{
            return new JsonResponse(['error' => 'Invalid token'], 400);
        }

    }
}
