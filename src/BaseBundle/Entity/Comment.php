<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 */
class Comment implements Entity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(min="1",max="255")
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var User
     */
    private $author;

    /**
     * @var BlogPost
     */
    private $blogPost;

    public function __construct(BlogPost $blogPost = null, User $author = null, $content = null)
    {
        $this->blogPost = $blogPost;
        $this->author = $author;
        $this->content = $content;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setBlogPost(BlogPost $blogPost)
    {
        $this->blogPost = $blogPost;
    }

    public function getBlogPost()
    {
        return $this->blogPost;
    }
}
