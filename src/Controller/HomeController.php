<?php


namespace App\Controller;


use App\Entity\Manga;
use App\Form\MangaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route(path="", name="manga_")
 */
class HomeController extends AbstractController
{

    /**
     * @Route(path="", name="index")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        //Object creation
        $manga = new Manga();
        //Attributes the form to the creation of the object
        $mangaForm = $this->createForm(MangaType::class, $manga);
        //If the user is not connected, displays the oiwa's list (me, Hi)
        if (is_null($this->getUser())) {
            $oiwa = $entityManager->getRepository('App:User')->findOneBy(['id' => 1]);
            $mangaList = $oiwa->getMangas();
            $editAllowed = false;
        } else {
            $manga->setAddedDate(new \DateTime('now'));
            $user = $entityManager->getRepository('App:User')->findOneBy(['username' => $this->getUser()->getUsername()]);
            $user->addManga($manga);
            $editAllowed = true;
            $mangaForm->handleRequest($request);
            if ($mangaForm->isSubmitted() && $mangaForm->isValid()) {
                //Adding $manga's data to the database
                $entityManager->persist($manga);
                $entityManager->flush();
                $this->addFlash('success', '' . $manga->getTitle() . ' has been added to the list !');
                return $this->redirectToRoute('manga_index');
            }
            $user = $this->getUser()->getUsername();
            $mangaList = $entityManager->getRepository('App:Manga')->getMangaUser($user);
        }
        return $this->render('home/index.html.twig',
            [
                'mangaForm' => $mangaForm->createView(),
                'mangaList' => $mangaList,
                'editAllowed' => $editAllowed
            ]);
    }
}