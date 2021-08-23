<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\UserDialogType;
use App\Service\CheckForCity;
use App\Service\SaveToDb;
use Dadata\DadataClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    protected EntityManagerInterface $em;
    protected SaveToDb $saver;
    protected CheckForCity $checker;

    /**
     * SiteController constructor.
     * @param EntityManagerInterface $em
     * @param SaveToDb $saver
     * @param CheckForCity $checker
     */
    public function __construct(EntityManagerInterface $em, SaveToDb $saver, CheckForCity $checker)
    {
        $this->em = $em;
        $this->saver = $saver;
        $this->checker = $checker;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function homepageAction(Request $request): Response
    {
        $session = $this->container->get('session');
        $address = new Address();
        $form = $this->createForm(UserDialogType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $addressValue = $request->get('user_dialog')['value'];
            if (!empty($addressValue)) {
                $dadata = new DadataClient($_ENV['APP_DADATA_API'], $_ENV['APP_DADATA_SECRET']);
                try {
                    $response = $dadata->clean("address", $addressValue);
                } catch (\Exception $e) {
                    $session
                        ->getFlashBag()
                        ->add('error', 'Что то пошло не так, повторите запрос.');
                    return $this->redirectToRoute('homepage');
                }
                if ($response) {
                    if ($this->checker->checkEqCityOrSettlement($response)) {
                        $session
                            ->getFlashBag()
                            ->add('success', 'Есть совпадение в городе или населенном пункте. Данные сохранены.');
                    } else {
                        $session
                            ->getFlashBag()
                            ->add('success', 'Адрес успешно сохранен.');
                    }
                    $this->saver->saveResultToDb($response);
                }
            }
            return $this->redirectToRoute('homepage');
        }

        return $this->render('dialog.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show_result", name="showResult")
     * @return Response
     */
    public function showResult(): Response
    {
        $q1 = $this->em->getRepository(Address::class)
            ->getAllAddress();

        $q2 = $this->em->getRepository(Address::class)
            ->getCityWithoutHoseId();

        $q3 = $this->em->getRepository(Address::class)
            ->getHouseInInterval();

        $q4 = $this->em->getRepository(Address::class)
            ->getStrangeStreet();

        return $this->render('result.html.twig', [
            'q1' => $q1,
            'q2' => $q2,
            'q3' => $q3,
            'q4' => $q4,
        ]);
    }
}