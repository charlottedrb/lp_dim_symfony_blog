<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        $postsRepo = $this->getDoctrine()->getRepository(Post::class);
        $posts = $postsRepo->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'posts' => $posts
        ]);
    }
}
