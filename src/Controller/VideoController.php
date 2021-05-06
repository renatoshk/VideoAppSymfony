<?php

namespace App\Controller;

use App\Entity\Video;
use App\Utils\CategoryFront;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @Route("/video-list/category/{categoryname}/{id}", name="video_list")
     */
    public function index($id, CategoryFront $categories)
    {
        $categories->getCategoryListAndParent($id);
        $videos = $this->getDoctrine()->getRepository(Video::class)
            ->findAll();
        return $this->render('front/video_list.html.twig', [
            'subCategories'=>$categories,
            'videos'=>$videos
        ]);
    }
    /**
     * @Route("/video-details", name="video_details")
     */
    public function videoDetails()
    {
        return $this->render('front/video_details.html.twig');
    }
}
