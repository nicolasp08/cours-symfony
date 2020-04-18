<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/booking/{page<\d+>?1}", name="admin_booking_index")
     */
    public function index(BookingRepository $repo, $page,PaginationService $pagination ){
        $pagination->setEntityClass(Booking::class)
                    ->setPage($page);
                  


        return $this->render('admin/booking/index.html.twig',[
            'pagination' => $pagination
            
        ]);

    }

/**
 * Permet d'éditer une réservation
 * 
 * @Route("/admin/booking/{id}/edit", name="admin_booking_edit")
 * 
 * @return Response
 */

 public function edit(Booking $booking, Request $request, EntityManagerInterface $manager ){
     $form = $this->createForm(AdminBookingType::class, $booking);

     $form ->handleRequest($request);

     if($form->isSubmitted() && $form->isValid()){
        $booking->setAmount(0);

        $manager->persist($booking); 
        $manager->flush();

        $this->addFlash(
            'success', "La réservation a bien été modifiée"
        );
        return $this->redirectToRoute('admin_booking_index');
     }

     return $this->render('admin/booking/edit.html.twig', [
         'form' => $form->createView(),
         'booking' => $booking
     ]);
 }

 /**
  * Permet de supprimer une annonce
  * @Route("/admin/booking/{id}/delete", name="admin_booking_delete")
  * @return Response
  */
 public function delete(Booking $booking, EntityManagerInterface $manager){
     $manager->remove($booking);
     $manager->flush();

     $this->addFlash(
         'success', "La réservation a bien été suprimée"
     );
     return $this->redirectToRoute("admin_booking_index");


 }
}
