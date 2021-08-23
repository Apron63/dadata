<?php

namespace App\Controller;

use App\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    protected EntityManagerInterface $em;

    /**
     * SiteController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/all_address/", name="allAddress")
     */
    public function getAllAddress(): JsonResponse
    {
        $data = $this->em->getRepository(Address::class)
            ->getAllAddress();

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/city_without_hose_id/", name="cityWithoutHoseId")
     */
    public function cityWithoutHoseId(): JsonResponse
    {
        $data = $this->em->getRepository(Address::class)
            ->getCityWithoutHoseId();

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/house_in_interval/", name="houseInInterval")
     */
    public function houseInInterval(): JsonResponse
    {
        $data = $this->em->getRepository(Address::class)
            ->getHouseInInterval();

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/strange_street/", name="strangeStreet")
     */
    public function strangeStreet(): JsonResponse
    {
        $data = $this->em->getRepository(Address::class)
            ->getStrangeStreet();

        return new JsonResponse($data);
    }
}