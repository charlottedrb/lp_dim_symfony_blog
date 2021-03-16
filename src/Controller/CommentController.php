<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/comment/new/{postId}', name: 'comment_new')]
    public function new(PostRepository $postRepository, UserRepository $userRepository, $postId, Request $request): Response
    {
        $user = $this->getUser();
        $post = $postRepository->findOneBy(['id' => $postId]);

        if($request->isMethod('POST')) {
            $data = $request->get('form');
            $comment = new Comment();
            $comment->setAuthor($user);
            $comment->setPost($post);
            $comment->setContent($data['content']);
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_show', ['id' => $postId]);
        }

        return $this->redirectToRoute('post_show', ['id' => $postId, 'error' => "Votre commentaire n'a pas pu être publié."]);
    }
}

/*$form = $this->createFormBuilder()
    ->add('content', TextareaType::class)
    ->add('save', SubmitType::class)
    ->getForm();

$user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => 'charlottedrb']);
$post = $this->getDoctrine()->getRepository(Post::class)->findOneBy(['id' => $postId]);

$form->submit();
if($form->isSubmitted() && $form->isValid()){
    $data =
    dd($data);
    $comment = new Comment();
    $comment->setAuthor($user);
    $comment->setPost($post);
    $comment->setContent($data);
    $this->getDoctrine()->getManager()->persist();
    $this->getDoctrine()->getManager()->flush();
}*/