<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Blog\ModelBundle\Entity\Author;
use Blog\ModelBundle\Entity\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Posts extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $p1 = new Post();
        $p1 -> setTitle('There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..');
        $p1 -> setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam finibus varius sollicitudin. Vivamus laoreet pulvinar elit sit amet dapibus. Donec cursus neque ac erat elementum tempor. Nullam a magna semper, eleifend orci quis, accumsan ipsum. Etiam non turpis dui. Morbi congue nisl mauris, eget porta enim ullamcorper eu. Maecenas massa purus, egestas at vestibulum et, volutpat vitae metus. Vivamus quam eros, porta ut arcu eget, pretium tempus lacus. Aenean et varius nulla. Praesent velit arcu, efficitur sed faucibus vitae, eleifend quis lorem. Vestibulum faucibus, ante sed tincidunt dapibus, ipsum purus hendrerit metus, quis imperdiet metus nisl sed nisi. Cras vel elit eget mauris interdum auctor. Praesent hendrerit eros sed accumsan elementum. Etiam volutpat libero a ultrices mattis.');
        $p1 -> setAuthor($this->getAuthor($manager, 'Chris'));

        $p2 = new Post();
        $p2 -> setTitle('There is no one who loves pain');
        $p2 -> setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam finibus varius sollicitudin. Vivamus laoreet pulvinar elit sit amet dapibus. Donec cursus neque ac erat elementum tempor. Nullam a magna semper, eleifend orci quis, accumsan ipsum. Etiam non turpis dui. Morbi congue nisl mauris, eget porta enim ullamcorper eu. Maecenas massa purus, egestas at vestibulum et, volutpat vitae metus. Vivamus quam eros, porta ut arcu eget, pretium tempus lacus. Aenean et varius nulla. Praesent velit arcu, efficitur sed faucibus vitae, eleifend quis lorem. Vestibulum faucibus, ante sed tincidunt dapibus, ipsum purus hendrerit metus, quis imperdiet metus nisl sed nisi. Cras vel elit eget mauris interdum auctor. Praesent hendrerit eros sed accumsan elementum. Etiam volutpat libero a ultrices mattis.');
        $p2 -> setAuthor($this->getAuthor($manager, 'david'));

        $p3 = new Post();
        $p3 -> setTitle('elsa world');
        $p3 -> setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam finibus varius sollicitudin. Vivamus laoreet pulvinar elit sit amet dapibus. Donec cursus neque ac erat elementum tempor. Nullam a magna semper, eleifend orci quis, accumsan ipsum. Etiam non turpis dui. Morbi congue nisl mauris, eget porta enim ullamcorper eu. Maecenas massa purus, egestas at vestibulum et, volutpat vitae metus. Vivamus quam eros, porta ut arcu eget, pretium tempus lacus. Aenean et varius nulla. Praesent velit arcu, efficitur sed faucibus vitae, eleifend quis lorem. Vestibulum faucibus, ante sed tincidunt dapibus, ipsum purus hendrerit metus, quis imperdiet metus nisl sed nisi. Cras vel elit eget mauris interdum auctor. Praesent hendrerit eros sed accumsan elementum. Etiam volutpat libero a ultrices mattis.');
        $p3 -> setAuthor($this->getAuthor($manager, 'david'));

        $manager -> persist($p1);
        $manager -> persist($p2);
        $manager -> persist($p3);

        $manager -> flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 15;
    }

    /**
     * find author by name
     * @param ObjectManager $manager
     * @param string        $name
     *
     * @return Author
     */
    private function getAuthor(ObjectManager $manager, $name) {
         return $manager -> getRepository('ModelBundle:Author') -> findOneBy(
            array(
                'name' => $name
            )
        );
    }
}