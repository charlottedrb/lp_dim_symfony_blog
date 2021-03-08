<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'post')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/post/{id}', name: 'post_show')]
    public function show(CommentRepository $commentRepository, PostRepository $postRepository, UserRepository $userRepository, $id): Response
    {
        $posts = $postRepository->findAll();
        $post = $postRepository->findOneBy(['id' => $id]);
        $user = $userRepository->findOneBy(['username' => 'charlottedrb']);
        $comments = $commentRepository->findByPost($id);

        $commentForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_new', ['postId' => $id]))
            ->add('content', TextareaType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'posts' => $posts,
            'form' => $commentForm->createView(),
            'comments' => $comments
        ]);
    }
}
