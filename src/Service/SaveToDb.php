<?php

namespace App\Service;

use App\Entity\Address;
use App\Entity\City;
use App\Entity\District;
use App\Entity\House;
use App\Entity\Region;
use App\Entity\Settlement;
use App\Entity\Street;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class SaveToDb
{
    protected EntityManagerInterface $em;

    /**
     * SaveToDb constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $response
     */
    public function saveResultToDb($response): void
    {
        // Save Region.
        if (null !== $response['region_fias_id']) {
            $region = $this->em->getRepository(Region::class)
                ->findOneBy(['fiasId' => $response['region_fias_id']]);
            if (null === $region) {
                $region = new Region();
                $region
                    ->setFiasId($response['region_fias_id'])
                    ->setName($response['region'])
                    ->setType($response['region_type']);
                $this->em->persist($region);
                $this->em->flush();
            }
        }

        // Save City.
        if (null !== $response['city_fias_id']) {
            $city = $this->em->getRepository(City::class)
                ->findOneBy(['fiasId' => $response['city_fias_id']]);
            if (null === $city) {
                $city = new City();
                $city
                    ->setFiasId($response['city_fias_id'])
                    ->setName($response['city'])
                    ->setType($response['city_type']);
                $this->em->persist($city);
                $this->em->flush();
            }
        }

        // Save District.
        if (null !== $response['city_district_fias_id']) {
            $district = $this->em->getRepository(District::class)
                ->findOneBy(['fiasId' => $response['city_district_fias_id']]);
            if (null === $district) {
                $district = new District();
                $district
                    ->setFiasId($response['city_district_fias_id'])
                    ->setName($response['city_district'])
                    ->setType($response['city_district_type']);
                $this->em->persist($district);
                $this->em->flush();
            }
        }

        // Save Settlement.
        if (null !== $response['settlement_fias_id']) {
            $settlement = $this->em->getRepository(Settlement::class)
                ->findOneBy(['fiasId' => $response['settlement_fias_id']]);
            if (null === $settlement) {
                $settlement = new Settlement();
                $settlement
                    ->setFiasId($response['settlement_fias_id'])
                    ->setName($response['settlement'])
                    ->setType($response['settlement_type']);
                $this->em->persist($settlement);
                $this->em->flush();
            }
        }

        // Save Street.
        if (null !== $response['street_fias_id']) {
            $street = $this->em->getRepository(Street::class)
                ->findOneBy(['fiasId' => $response['street_fias_id']]);
            if (null === $street) {
                $street = new Street();
                $street
                    ->setFiasId($response['street_fias_id'])
                    ->setName($response['street'])
                    ->setType($response['street_type']);
                $this->em->persist($street);
                $this->em->flush();
            }
        }

        // Save House.
        if (null !== $response['house_fias_id']) {
            $house = $this->em->getRepository(House::class)
                ->findOneBy(['fiasId' => $response['house_fias_id']]);
            if (null === $house) {
                $house = new House();
                $house
                    ->setFiasId($response['house_fias_id'])
                    ->setName($response['house'])
                    ->setType($response['house_type'])
                    ->setCreatedAt(new DateTime());
                $this->em->persist($house);
                $this->em->flush();
            }
        }

        // Save Address.
        $address = new Address();
        $address
            ->setValue($response['source'])
            ->setRegion($region ?? null)
            ->setCity($city ?? null)
            ->setDistrict($district ?? null)
            ->setSettelment($settlement ?? null)
            ->setStreet($street ?? null)
            ->setHouse($house ?? null)
            ->setCreatedAt(new DateTime());
        $this->em->persist($address);

        $this->em->flush();
    }
}