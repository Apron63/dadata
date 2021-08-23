<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 * @UniqueEntity(fields="value")
 *
 * @ApiResource(
 *     itemOperations={
 *       "allAddress"={
 *           "path"="/api/all_address/",
 *       },
 *       "cityWithoutHoseId"={
 *           "path"="/api/city_without_hose_id/",
 *       },
 *      "houseInInterval"={
 *           "path"="api/house_in_interval/",
 *       }
 * })
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1024, unique=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class)
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity=District::class)
     */
    private $district;

    /**
     * @ORM\ManyToOne(targetEntity=City::class)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=Street::class)
     */
    private $street;

    /**
     * @ORM\ManyToOne(targetEntity=House::class)
     */
    private $house;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Settlement::class)
     */
    private $settlement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?Street
    {
        return $this->street;
    }

    public function setStreet(?Street $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouse(): ?House
    {
        return $this->house;
    }

    public function setHouse(?House $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSettlement(): ?Settlement
    {
        return $this->settlement;
    }

    public function setSettelment(?Settlement $settlement): self
    {
        $this->settlement = $settlement;

        return $this;
    }
}
