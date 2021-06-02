<?php


namespace App\Controller;


use App\Entity\Status;
use App\Form\StatusType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @Route(path="admin/", name="admin_")
 * @package App\Controller
 */
class AdminController extends AbstractController
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="status", name="status")
     */
    public function manageStatus(Request $request, EntityManagerInterface $entityManager): Response
    {
        $status = new Status();
        $statusForm = $this->createForm(StatusType::class, $status);
        $statusForm->handleRequest($request);

        $statusList = $entityManager->getRepository('App:Status')->findAll();
        if ($statusForm->isSubmitted() && $statusForm->isValid()) {
            //Persistance des données
            $entityManager->persist($status);
            $entityManager->flush();
            //Si le formulaire est valide, actualisation de la page
            return $this->redirectToRoute('admin_status', ['statusList' => $statusList]);
        }
        return $this->render('admin/status.html.twig',
            [
                'statusForm' => $statusForm->createView(),
                'statusList' => $statusList
            ]);

    }
}