<?php

namespace App\Service;

use App\Entity\City;
use App\Entity\Settlement;
use Doctrine\ORM\EntityManagerInterface;

class CheckForCity
{
    protected EntityManagerInterface $em;

    /**
     * CheckForCity constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $response
     * @return bool
     */
    public function checkEqCityOrSettlement(array $response): bool
    {
        if (null !== $response['city_fias_id']) {
            $city = $this->em->getRepository(City::class)
                ->findOneBy(['fiasId' => $response['city_fias_id']]);
            if ($city) {
                return true;
            }
        }

        if (null !== $response['settlement_fias_id']) {
            $settlement = $this->em->getRepository(Settlement::class)
                ->findOneBy(['fiasId' => $response['settlement_fias_id']]);
            if ($settlement) {
                return true;
            }
        }

        return false;
    }
}