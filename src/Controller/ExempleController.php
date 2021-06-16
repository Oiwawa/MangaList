<?php


namespace App\Controller;


use App\Data\SearchData;
use App\Form\SearchForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ExempleController
 * @package App\Controller
 * @Route(path="Oiwa", name="oiwa_")
 */
class ExempleController extends AbstractController
{

    /**
     * @Route(path="", name="index")
     */
    public function exempleList(EntityManagerInterface $entityManager, Request $request): Response
    {
        $oiwa = $entityManager->getRepository('App:User')->findOneBy(['id' => 1]);
        $mangaList = $oiwa->getMangas();

        // Filters
        $data = new SearchData();
        $filtersForm = $this->createForm(SearchForm::class, $data);
        $filtersForm->handleRequest($request);
        if ($filtersForm->isSubmitted()  && $filtersForm->isValid()) {
            $mangaList = $entityManager->getRepository('App:Manga')->findSearch($data, $oiwa);
            if(empty($mangaList)) {
                $this->addFlash('danger', 'We did not find any manga corresponding to your research!');
            }
        }
        return $this->render('home/exempleView.html.twig', [
            'mangaList' => $mangaList,
            'filtersForm'=>$filtersForm->createView()
        ]);
    }
}