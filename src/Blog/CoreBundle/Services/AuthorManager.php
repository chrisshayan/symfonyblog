<?php

namespace Blog\CoreBundle\Services;
use Blog\ModelBundle\Entity\Author;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Created by PhpStorm.
 * User: chrisshayan
 * Date: 4/14/17
 * Time: 12:49 AM
 */
class AuthorManager
{
    private $em;

    public function __construct(EntityManager $entityManager) {
        $this ->em = $entityManager;
    }

    /**
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * @return Author
     */
    public function findBySlug($slug) {
        $author = $this -> em -> getRepository('ModelBundle:Author') -> findOneBy(
            array(
                'slug' => $slug
            )
        );

        if (null === $author) {
            throw new NotFoundHttpException('no author found');
        }

        return $author;
    }

    /**
     * @param Author $author
     *
     * @return array|\Blog\ModelBundle\Entity\Post[]
     */
    public function findPostsByAuthor(Author $author) {
        $posts = $this -> em -> getRepository('ModelBundle:Post') -> findBy(
            array(
                'author' => $author
            )
        );
        return $posts;
    }
}