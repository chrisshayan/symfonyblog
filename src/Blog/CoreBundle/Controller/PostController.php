<?php

namespace Blog\CoreBundle\Controller;

use Blog\CoreBundle\Services\PostManager;
use Blog\ModelBundle\Entity\Comment;
use Blog\ModelBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostController
 */
class PostController extends Controller
{
    /**
     * @return array
     * 
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $posts = $this -> getManager() -> findAll();
        $latestPosts = $this -> getManager() -> findLatest(5);

        return array(
            'posts'       => $posts,
            'latestPosts' => $latestPosts
        );
    }

    /**
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * @return array
     *
     * @Route("/{slug}")
     * @Template()
     */
    public function showAction($slug) : array
    {
        $post = $this -> getManager() -> findBySlug($slug);
        $form = $this -> createForm(new CommentType());

        return array(
          'post' => $post,
          'form' => $form -> createView()
        );
    }


    /**
     * @param Request $request
     * @param string  $slug
     *
     * @throws NotFoundHttpException
     * @return array
     *
     * @Route("/{slug}/create-comment")
     * @Method("POST")
     * @Template("CoreBundle:Post:show.html.twig")
     *
     */
    public function createCommentAction(Request $request, $slug)
    {
        $post = $this -> getDoctrine() -> getRepository('ModelBundle:Post') -> findOneBy(
            array(
                'slug' => $slug
            )
        );

        if (null === $post) {
            throw $this -> createNotFoundException('Post was not found');
        }

        $comment = new Comment();
        $comment -> setPost($post);

        $form = $this -> createForm(new CommentType(), $comment);
        $form -> handleRequest($request);

        if($form -> isValid()) {
            $this -> getDoctrine() -> getManager() -> persist($comment);
            $this -> getDoctrine() -> getManager() -> flush();
            
            $this -> get('session') -> getFlashBag() -> add('success', 'Your comment wa saved.');

            return $this -> redirect(
                $this -> generateUrl('blog_core_post_show', array( 'slug' => $post -> getSlug()))
            );
        }
        return array(
            'post' => $post,
            'form' => $form -> createView()
        );
    }

    /**
     * @return PostManager
     */
    private function getManager() {
        return $this->get('post_manager');
    }

}
