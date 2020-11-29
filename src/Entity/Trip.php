<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TripRepository::class)
 */
class Trip
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destenation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fellowPassenger;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tripStartDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tripEndDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPackingFinished;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDestenation(): ?string
    {
        return $this->destenation;
    }

    public function setDestenation(string $destenation): self
    {
        $this->destenation = $destenation;

        return $this;
    }

    public function getFellowPassenger(): ?string
    {
        return $this->fellowPassenger;
    }

    public function setFellowPassenger(?string $fellowPassenger): self
    {
        $this->fellowPassenger = $fellowPassenger;

        return $this;
    }

    public function getTripStartDate(): ?\DateTimeInterface
    {
        return $this->tripStartDate;
    }

    public function setTripStartDate(?\DateTimeInterface $tripStartDate): self
    {
        $this->tripStartDate = $tripStartDate;

        return $this;
    }

    public function getTripEndDate(): ?\DateTimeInterface
    {
        return $this->tripEndDate;
    }

    public function setTripEndDate(?\DateTimeInterface $tripEndDate): self
    {
        $this->tripEndDate = $tripEndDate;

        return $this;
    }

    public function getIsPackingFinished(): ?bool
    {
        return $this->isPackingFinished;
    }

    public function setIsPackingFinished(bool $isPackingFinished): self
    {
        $this->isPackingFinished = $isPackingFinished;

        return $this;
    }

    public function transformToArray()
    {
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'destenation' => $this->getDestenation(),
            'fellowPassenger' => $this->getFellowPassenger(),
            'tripStartDate' => $this->getTripStartDate(),
            'tripEndDate' => $this->getTripEndDate(),
            'isPackingFinished' => $this->getIsPackingFinished(),
        ];
        return $data;
    }
}
