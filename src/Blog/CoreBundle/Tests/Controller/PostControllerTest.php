<?php

namespace Blog\CoreBundle\Tests\Controller;

use Blog\ModelBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this -> assertTrue($client -> getResponse() -> isSuccessful(), 'index is not good to go.');

        $this -> assertCount(3, $crawler -> filter('h2'), 'there should be 3 displayed posts');
    }


    public function testShow()
    {
        $client = static::createClient();

        /** @var Post $post */
        $post = $client -> getContainer()
            -> get('doctrine')
            -> getManager()
            -> getRepository('ModelBundle:Post')
            ->findFirst();

        $crawler = $client->request('GET', '/'.$post -> getSlug());
        $this -> assertTrue($client -> getResponse() -> isSuccessful(), 'get slug did not work');
        $this -> assertEquals($post->getTitle(),
            $crawler-> filter('h1') -> text(), 'invalid post title');

        $this -> assertGreaterThanOrEqual(1,
            $crawler -> filter('article.comment') -> count(), 'There should be one comment,');
    }

    public function testCreateComment()
    {
        $client = static::createClient();

        /** @var Post $post */
        $post = $client -> getContainer()
            -> get('doctrine')
            -> getManager()
            -> getRepository('ModelBundle:Post')
            ->findFirst();

        $crawler = $client->request('GET', '/'.$post -> getSlug());
        $button  = $crawler -> selectButton('Send');
        $form    = $button -> form(array(
            'blog_modelbundle_comment[authorName]' => 'A humble commenter',
            'blog_modelbundle_comment[body]' => 'Hi, I am commenting about symfony2'
        ));
        $client -> submit($form);


        $this -> assertTrue($client -> getResponse() -> isRedirect('/'.$post -> getSlug()), 'no redirect');
        $crawler = $client -> followRedirect();
        $this -> assertCount(1,
            $crawler -> filter('html:contains("Your comment wa saved.")'), 'no comment is found');
    }


}
