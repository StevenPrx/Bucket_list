<?php

namespace App\Entity;

use App\Repository\IdeaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"title"})
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=IdeaRepository::class)
 */
class Idea
{
    /**
     * @ORM\PrePersist()
     */
    public function beforeFirstSave(){
        $this->setIsPublished(true);
        $this->setDateCreated(new \DateTime());
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please provide a title for the idea!")
     * @Assert\Length(max=250, maxMessage="Max 250 characters")
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private $title;

    /**
     * @Assert\Length(max=255, maxMessage="Max 255 characters")
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $description;

    /**
     * @Assert\Length(max=15, maxMessage="Max 15 characters")
     * @ORM\Column(type="string", length=15)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="ideas", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getisPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished): void
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(?Category $category)
    {
        $this->category = $category;

        return $this;
    }


}
