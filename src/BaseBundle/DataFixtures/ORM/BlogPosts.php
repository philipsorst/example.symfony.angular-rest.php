<?php
namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;

class BlogPosts extends AbstractFixture implements DependentFixtureInterface
{
    const BLOG_POST_1 = 'blog-post-1';
    const BLOG_POST_2 = 'blog-post-2';

    public function load(ObjectManager $manager)
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle('Blog Post 1');
        $blogPost->setContent('Blog Post 1 Content');
        $blogPost->setAuthor($this->getUserReference(Users::USER));
        $blogPost->setDate(new \DateTime());
        $manager->persist($blogPost);
        $manager->flush();

        $this->setReference(self::BLOG_POST_1, $blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle('Blog Post 2');
        $blogPost->setContent('Blog Post 2 Content');
        $blogPost->setAuthor($this->getUserReference(Users::ADMIN));
        $blogPost->setDate(new \DateTime());
        $manager->persist($blogPost);
        $manager->flush();

        $this->setReference(self::BLOG_POST_2, $blogPost);
    }

    public function getDependencies()
    {
        return [Users::class];
    }
}
