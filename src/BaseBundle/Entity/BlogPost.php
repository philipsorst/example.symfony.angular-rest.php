<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class BlogPost implements Entity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(min="1",max="63")
     * @var string
     */
    private $title;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(min="1",max="511")
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var int
     */
    private $numComments = 0;

    /**
     * @var Collection|Comment[]
     */
    private $comments;

    /**
     * @var User
     */
    private $author;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setNumComments($numComments)
    {
        $this->numComments = $numComments;
    }

    public function getNumComments()
    {
        return $this->numComments;
    }
}
