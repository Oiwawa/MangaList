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
     * @Route(path="delete/{id}", name="delete")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(EntityManagerInterface $entityManager, Request $request): RedirectResponse
    {
        $manga = $entityManager->getRepository('App:Manga')->findOneBy(['id' => $request->get('id')]);

        if($this->getUser() === $manga->getUser()){

        $user = $entityManager->getRepository('App:User')->findOneBy(['username' => $this->getUser()->getUsername()]);
        $user->removeManga($manga);
        $entityManager->remove($manga);
        $entityManager->flush();

        $this->addFlash('success', '' . $manga->getTitle() . ' has been deleted from your list.');
        } else {
            $this->addFlash('warning', 'You can only delete items from your own list.');
        }
        return $this->redirectToRoute('manga_index');
    }
}