<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textSmall;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Data", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getTextSmall(): ?string
    {
        return $this->textSmall;
    }

    public function setTextSmall(string $textSmall): self
    {
        $this->textSmall = $textSmall;

        return $this;
    }

    public function getData(): ?Data
    {
        return $this->data;
    }

    public function setData(Data $data): self
    {
        $this->data = $data;

        return $this;
    }
}
