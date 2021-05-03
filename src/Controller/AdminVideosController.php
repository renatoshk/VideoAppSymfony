<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin")
 */
class AdminVideosController extends AbstractController
{
    /**
     * @Route("/videos", name="videos")
     */
    public function index()
    {
        return $this->render('admin/videos.html.twig');
    }
    /**
     * @Route("/upload_video", name="upload_video")
     */
    public function uploadVideo()
    {
        return $this->render('admin/upload_video.html.twig');
    }
}
