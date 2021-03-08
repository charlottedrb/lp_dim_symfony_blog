<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'post')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('post_new'))
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'form' => $form->createView()
        ]);
    }

    #[Route('/post/new', name: 'post_new')]
    public function new(UserRepository $userRepository, Request $request){
        $user = $userRepository->findOneBy(['username' => 'charlottedrb']);

        if($request->isMethod('POST')) {
            $data = $request->get('form');
            $post = new Post();
            $post->setAuthor($user);
            $post->setTitle($data['title']);
            $post->setContent($data['content']);
            $post->setCreatedAt(new \DateTime('NOW'));
            $post->setIsDeleted(false);
            $post->setIsPublished(true);
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post');
        }
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
