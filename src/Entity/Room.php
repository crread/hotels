<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 */
class Room
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_room;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_beds;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_hotel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberRoom(): ?int
    {
        return $this->number_room;
    }

    public function setNumberRoom(int $number_room): self
    {
        $this->number_room = $number_room;

        return $this;
    }

    public function getNumberBeds(): ?int
    {
        return $this->number_beds;
    }

    public function setNumberBeds(int $number_beds): self
    {
        $this->number_beds = $number_beds;

        return $this;
    }

    public function getIdHotel(): ?Hotel
    {
        return $this->id_hotel;
    }

    public function setIdHotel(?Hotel $id_hotel): self
    {
        $this->id_hotel = $id_hotel;

        return $this;
    }
}
