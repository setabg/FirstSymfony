<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $postRepository){
        $posts=$postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts'=>$posts
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request){
        $post=new Post();

        $post->setTitle('Title');

        //entity manager
        $em=$this->getDoctrine()->getManager();

        $em->persist($post);
        $em->flush();

        //return a response
        return $this->redirect($this->generateUrl('post.index'));
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post){

        //create the show view
        return $this->render('post/show.html.twig', [
            'post'=>$post
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Post $post
     */
    public function remove(Post $post){

        $em=$this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'The post was removed');

        return $this->redirect($this->generateUrl('post.index'));
    }
}
