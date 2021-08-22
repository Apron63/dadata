<?php

namespace App\Controller;

use App\Form\UserDialogType;
use App\Service\SaveToDb;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    protected EntityManagerInterface $em;
    protected SaveToDb $saver;

    /**
     * SiteController constructor.
     * @param EntityManagerInterface $em
     * @param SaveToDb $saver
     */
    public function __construct(EntityManagerInterface $em, SaveToDb $saver)
    {
        $this->em = $em;
        $this->saver = $saver;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function homepageAction(Request $request): Response
    {
        $form = $this->createForm(UserDialogType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $request->get('user_dialog')['address'];
            if (!empty($address)) {
                $dadata = new \Dadata\DadataClient($_ENV['APP_DADATA_API'], $_ENV['APP_DADATA_SECRET']);
                $response = $dadata->clean("address", $address);
                if ($response) {
                    $this->saver->saveResultToDb($response);
                }
            }
            return $this->redirectToRoute('homepage');
        }

        return $this->render('dialog.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}