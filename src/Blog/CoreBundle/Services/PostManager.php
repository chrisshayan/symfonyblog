<?php

namespace Blog\CoreBundle\Services;
use Blog\ModelBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Created by PhpStorm.
 * User: chrisshayan
 * Date: 4/14/17
 * Time: 12:49 AM
 */
class PostManager
{
    private $em;

    public function __construct(EntityManager $entityManager) {
        $this ->em = $entityManager;
    }

    /**
     * @return array
     */
    public function findAll() {
       return $this -> em -> getRepository('ModelBundle:Post') -> findAll();
    }

    /**
     * @param int $num
     *
     * @return array
     */
    public function findLatest($num) {
       return $this -> em -> getRepository('ModelBundle:Post') -> findLatest($num);
    }


    /**
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * @return Post
     */
    public function findBySlug($slug) {
        $post = $this -> em -> getRepository('ModelBundle:Post') -> findOneBy(
            array(
                'slug' => $slug
            )
        );

        if (null === $post)
        {
            throw new NotFoundHttpException('Post was not found');
        }

        return $post;
    }
}