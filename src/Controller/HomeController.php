<?php


namespace App\Controller;


use App\Data\SearchData;
use App\Entity\Manga;
use App\Form\MangaType;
use App\Form\SearchForm;
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
        //If the user is not connected, displays the oiwa's list (me, Hi)
        if (is_null($this->getUser())) {
            return $this->redirectToRoute('oiwa_index');
        } else {
            //Gets the user's id for later use
            $user = $entityManager->getRepository('App:User')->findOneBy(['username' => $this->getUser()->getUsername()]);
            $username = $user->getUsername();
//            $mangaList = $entityManager->getRepository('App:Manga')->getMangaUser($user);
            $mangaList = $user->getMangas();
            // Filters
            $data = new SearchData();
            $filtersForm = $this->createForm(SearchForm::class, $data);
            $filtersForm->handleRequest($request);
            if ($filtersForm->isSubmitted() && $filtersForm->isValid()) {
                if (empty($mangaList)) {
                    $this->addFlash('danger', 'We did not find any manga corresponding to your research!');
                }
            }
            $mangaList = $entityManager->getRepository('App:Manga')->findSearch($data, $username);
            // Adding a new manga to the list
            $manga = new Manga();
            $mangaForm = $this->createForm(MangaType::class, $manga);

            //Attributes the form to the creation of the object
            $manga->setAddedDate(new \DateTime('now'));
            $user->addManga($manga);
            $mangaForm->handleRequest($request);
            if ($mangaForm->isSubmitted() && $mangaForm->isValid()) {
                //Adding new manga to the database if the form is valid
                $entityManager->persist($manga);
                $entityManager->flush();
                $this->addFlash('success', '' . $manga->getTitle() . ' has been added to the list !');
                return $this->redirectToRoute('manga_index');
            }
            return $this->render('home/index.html.twig',
                [
                    'mangaForm' => $mangaForm->createView(),
                    'filtersForm' => $filtersForm->createView(),
                    'mangaList' => $mangaList,
                ]);
        }
    }
}