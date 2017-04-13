<?php

namespace Blog\CoreBundle\Controller;

use Blog\CoreBundle\Services\AuthorManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AuthorController
 * @package Blog\CoreBundle\Controller
 */
class AuthorController extends Controller
{
    /**
     * @param string $slug
     *
     * @Route("/author/{slug}")
     * @Template()
     *
     * @throws NotFoundHttpException
     * @return array
     */
    public function showAction($slug)
    {
        $author = $this -> getAuthorManager() -> findBySlug($slug);
        $posts =  $this -> getAuthorManager() -> findPostsByAuthor($author);

        return array(
            'author' => $author,
            'posts'  => $posts
        );
    }

    /**
     * @return AuthorManager
     */
    private function getAuthorManager() {
        return $this->get('author_manager');
    }

}
