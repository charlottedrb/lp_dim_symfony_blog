<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\CommentRepository;
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

    /*#[Route('/comment/edit/{id}', name: 'comment_edit')]
    public function edit(Request $request, $id, CommentRepository $commentRepository): Response
    {
        if($request->isMethod('POST')) {
            $this->addFlash('edit_success', 'Your comment has been edited.');
            $comment = $commentRepository->findOneBy(['id' => $id]);

            $this->getDoctrine()->getManager()->remove($comment);
            $this->getDoctrine()->getManager()->flush();
        } else {
            $this->addFlash('error', 'An error occurred please try again.');
        }
        return $this->redirect($request->headers->get('referer'));
    }*/

    #[Route('/comment/delete/{id}', name: 'comment_delete')]
    public function delete(Request $request, $id, CommentRepository $commentRepository): Response
    {
        try{

            $this->addFlash('delete_success', 'Your comment has been deleted.');
            $comment = $commentRepository->findOneBy(['id' => $id]);

            $this->getDoctrine()->getManager()->remove($comment);
            $this->getDoctrine()->getManager()->flush();
        } catch(\Exception) {
            $this->addFlash('error', 'An error occurred please try again.');
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
