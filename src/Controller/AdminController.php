<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/listHotels", name="listHotels")
     */
    public function getListHotels(EntityManagerInterface $em){
        $repository = $em->getRepository( Hotel::class );
        $hotels = $repository->findAll();
        dd($hotels);
    }
}
