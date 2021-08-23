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
            SELECT (SECOND(h.createdAt)) AS sec
            FROM App\Entity\House h
        ");
        return $query->getArrayResult();
    }
}
