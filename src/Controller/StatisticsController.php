<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function statistics(){

        return $this->render('manga/statistics.html.twig');
    }

}