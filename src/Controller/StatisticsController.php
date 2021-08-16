<?php


namespace App\Controller;


use App\Entity\Manga;
use App\Service\CallApiService;
use Doctrine\ORM\EntityManagerInterface;
use Jikan\MyAnimeList\MalClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StatisticsController
 * @package App\Controller
 * @Route(path="stats", name="stats_")
 */
class StatisticsController extends AbstractController
{

    /**
     * @Route(path="", name="index")
     */
    public function statistics(): Response
    {

    $highestRankedManga = $this->getHighestRankMangas();

       return $this->render("manga/statistics.html.twig",
       [
           'highestRankedManga' => $highestRankedManga
       ]
       );
    }


    private function getHighestRankMangas(EntityManagerInterface $entityManager): array
    {
        return $entityManager->getRepository('App:Manga')->findHighestMangas();
    }
}