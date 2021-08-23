<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * @return array|null
     */
    public function getAllAddress(): ?array
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT r.name, COUNT(a.id) AS cnt
            FROM App\Entity\Address a
            LEFT JOIN App\Entity\Region r WITH r.id = a.region
            GROUP BY r.id
        ");
        return $query->getArrayResult();
    }

    /**
     * @return array|null
     */
    public function getCityWithoutHoseId(): ?array
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT c.name, COUNT(a.id) AS cnt
            FROM App\Entity\City c
            LEFT JOIN App\Entity\Address a WITH a.city = c.id
            WHERE a.house IS NULL
            GROUP BY c.id
        ");
        return $query->getArrayResult();
    }

    /**
     * @return array|null
     */
    public function getHouseInInterval(): ?array
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT h.createdAt AS created, a.value as addr
            FROM App\Entity\House h
            JOIN App\Entity\Address a WITH a.house = h.id
            WHERE second(h.createdAt) BETWEEN 20 AND 40
        ");
        return $query->getArrayResult();
    }

    /**
     * @return array|null
     */
    public function getStrangeStreet(): ?array
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT a.value AS value, s.type AS type
            FROM App\Entity\Street s
            JOIN App\Entity\Address a WITH a.street = s.id
            WHERE s.type != :exclude
        ")
            ->setParameter('exclude', Address::ORDINARY_TYPE);
        return $query->getArrayResult();
    }
}
