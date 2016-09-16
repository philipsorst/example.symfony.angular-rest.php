<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var NewsEntry
     */
    private $newsEntry;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author
     *
     * @param User $author
     *
     * @return Comment
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set newsEntry
     *
     * @param NewsEntry $newsEntry
     *
     * @return Comment
     */
    public function setNewsEntry(NewsEntry $newsEntry)
    {
        $this->newsEntry = $newsEntry;

        return $this;
    }

    /**
     * Get newsEntry
     *
     * @return NewsEntry
     */
    public function getNewsEntry()
    {
        return $this->newsEntry;
    }
}
