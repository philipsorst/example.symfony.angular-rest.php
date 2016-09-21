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
        $blogPost1 = new BlogPost();
        $blogPost1->setTitle('Blog Post 1');
        $blogPost1->setContent('Blog Post 1 Content');
        $blogPost1->setAuthor($this->getUserReference(Users::USER));
        $blogPost1->setDate(new \DateTime());
        $manager->persist($blogPost1);
        $manager->flush();

        $this->setReference(self::BLOG_POST_1, $blogPost1);

        $blogPost2 = new BlogPost();
        $blogPost2->setTitle('Blog Post 2');
        $blogPost2->setContent('Blog Post 2 Content');
        $blogPost2->setAuthor($this->getUserReference(Users::ADMIN));
        $blogPost2->setDate(new \DateTime());
        $manager->persist($blogPost2);
        $manager->flush();

        $this->setReference(self::BLOG_POST_2, $blogPost2);
    }

    public function getDependencies()
    {
        return [Users::class];
    }
}
