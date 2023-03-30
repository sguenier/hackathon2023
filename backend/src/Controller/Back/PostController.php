<?php

namespace App\Controller\Back;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/post')]
class PostController extends AbstractController
{
    //rajouter verif CSRF sur les routes
    #[Route('s/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        // return json response
        return $this->json($postRepository->findAll());
    }

    #[Route('/new/', name: 'app_post_new', methods: ['POST'])]
    public function new(Request $request, PostRepository $postRepository, UserRepository $userRepository): Response
    {

        $data['title'] = $request->request->get('title') ?? null;
        $data['content'] = $request->request->get('content') ?? null;

        if($data['title'] == null || $data['content'] == null) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        $post = new Post();

        if (!isset($data['title']) || !isset($data['content']) ) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

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

        $image = $request->files->get('image');
        if($image != null) {
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
                $this->getParameter('posts_directory'),
                $imageName
            );

            if(!file_exists($this->getParameter('posts_directory') . '/' . $imageName)) {
                return new JsonResponse(['error' => 'Image not saved'], 400);
            }

        }else{
            return new JsonResponse(['error' => 'Missing image'], 400);
        }

        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $post->setAuthor($user);
        // set image to empty
        $post->setImage($imageName);
        $post->setCreatedAt(new \DateTimeImmutable());

        // create the post
        $postRepository->save($post, true);
        if($post->getId() == null) {
            return new JsonResponse(['error' => 'Post not created'], 400);
        }else{  
            return new JsonResponse(['message' => 'Post created'], 201);
        }
        
    }

    #[Route('/{id}/', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        $jsonedPost = [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'image' => $post->getImage(),
            'created_at' => $post->getCreatedAt()
        ]; 
        // 'author' => $post->getAuthor()->getUsername(),

        return new JsonResponse($jsonedPost); 
    }

    #[Route('/{id}/', name: 'app_post_edit', methods: ['POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository, UserRepository $userRepository): Response
    {
       
        $data['title'] = $request->request->get('title') ?? null;
        $data['content'] = $request->request->get('content') ?? null;
        
        if (!isset($data['title']) || !isset($data['content']) ) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }


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


        $image = $request->files->get('image');
        if($image != null) {
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
                $this->getParameter('posts_directory'),
                $imageName
            );

            if(!file_exists($this->getParameter('posts_directory') . '/' . $imageName)) {
                return new JsonResponse(['error' => 'Image not saved'], 400);
            }else{
                  // remove the old image
                if(file_exists($this->getParameter('posts_directory') . '/' . $post->getImage())) {
                    unlink($this->getParameter('posts_directory') . '/' . $post->getImage());
                }
            }

            $post->setImage($imageName);
        }
        
            $post->setTitle($data['title']);
            $post->setContent($data['content']);

            // $post->setUpdatedAt(new \DateTimeImmutable());
            $postRepository->save($post, true);
            // return the updated post
            $jsonedPost = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'image' => $post->getImage(),
                'created_at' => $post->getCreatedAt()
            ];
            return new JsonResponse($jsonedPost);
    }

    #[Route('/{id}/', name: 'app_post_delete', methods: ['DELETE'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository , UserRepository $userRepository): Response
    {
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

        if($post->getImage() != null){
            $imagepath = $this->getParameter('posts_directory') . '/' . $post->getImage();
        }else{
            $imagepath = null;
        }

        $postRepository->remove($post, true);
        if($post->getId() != null) {
            return new JsonResponse(['error' => 'Post not deleted'], 400);
        }else{
            if($imagepath != null){
                if(file_exists($imagepath)) {
                    unlink($imagepath);
                }
            }
           
            return $this->json(['message' => 'Post deleted']);
        }
    }
}
