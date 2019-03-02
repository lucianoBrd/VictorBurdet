<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DataRepository")
 */
class Data
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le fichier doit être une image ou une vidéo.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg", "video/mpeg" })
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $extension;

    /**
     * @ORM\Column(type="boolean")
     */
    private $home;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getHome(): ?bool
    {
        return $this->home;
    }

    public function setHome(bool $home): self
    {
        $this->home = $home;

        return $this;
    }
}
