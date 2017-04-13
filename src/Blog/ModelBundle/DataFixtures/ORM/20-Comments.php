<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Blog\ModelBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class Comments
 * @package Blog\ModelBundle\DataFixtures\ORM
 */
class Comments extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 20;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $posts = $manager -> getRepository('ModelBundle:Post') -> findAll();
        $comments = array(
          0 => 'This is a comment. This is a comment.This is a comment.This is a comment.This is a comment.This is a comment.This is a comment.',
          1 => 't is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',
          2 => 'rem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ip'
        );

        $counter = 0;
        foreach ($posts as $post)
        {
            $comment = new Comment();
            $comment -> setAuthorName('Sonny Khoa Lan Tuan');
            $comment -> setBody($comments[$counter++]);
            $comment -> setPost($post);

            $manager -> persist($comment);
        }

        $manager -> flush();
    }

}