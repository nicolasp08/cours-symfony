<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\AdminUserType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends AbstractController
{
    /**
     * Permet d'afficher la liste des utilisateurs
     * @Route("/admin/user", name="admin_user_index")
     * 
     */
    public function index(AdRepository $repo)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);

        $users = $repo->findAll();
        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     * 
     * @Route("/admin/user/{id}/edit", name="admin_user_edit")
     *
     * @return void
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "L'annonce a bien été enregistrée");
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
            ]);


    }
}
