<?php


namespace App\Controller;


use App\Form\MangaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MangaController
 * @package App\Controller
 * @Route(path="manga/", name="manga_")
 */
class MangaController extends AbstractController
{

    /**
     * @Route(path="update/{id}", name="update")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(EntityManagerInterface $entityManager, Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $manga = $entityManager->getRepository('App:Manga')->findOneBy(['id' => $request->get('id')]);
        $mangaUpdateForm = $this->createForm(MangaType::class, $manga);
        $mangaUpdateForm->handleRequest($request);
        if ($mangaUpdateForm->isSubmitted() && $mangaUpdateForm->isValid()) {
            $entityManager->flush();
            $this->redirectToRoute('manga_index');
        }

        return $this->render('manga/mangaUpdate.html.twig', [
            'mangaUpdateForm' => $mangaUpdateForm->createView(),
            'manga' => $manga
        ]);
    }

    /**
     * @Route(path="delete/{id}", name="delete")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(EntityManagerInterface $entityManager, Request $request): RedirectResponse
    {
            $manga = $entityManager->getRepository('App:Manga')->findOneBy(['id' => $request->get('id')]);
            $user = $entityManager->getRepository('App:User')->findOneBy(['username' => $this->getUser()->getUsername()]);
            $user->removeManga($manga);
            $entityManager->remove($manga);
            $entityManager->flush();
            $this->addFlash('success', '' . $manga->getTitle() . ' has been deleted from your list.');

        return $this->redirectToRoute('manga_index');
    }
}