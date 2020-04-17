<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Repository\AdRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments", name="admin_comment_index")
     */
    public function index(AdRepository $repo)
    {
        $repo = $this->getDoctrine()->getRepository(Comment::class);

        $comments = $repo->findAll();
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

     /**
     * Permet d'afficher le formulaire d'édition de commentaire
     *
     * @Route("/admin/comments/{id}/edit", name="admin_comment_edit")
     * 
     * @return Response
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(AdminCommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success', "Le commentaire n° {$comment->getId()} a bien été modifié"
            );
        }
    return $this->render('admin/comment/edit.html.twig', [
        'comment' => $comment,
        'form' => $form->createView()
    ]);  

    }
    /**
     * Permet de supprimer un commentaire
     * @Route("/admin/comments/{id}/delete", name="admin_comment_delete")
     * @param Commment $comment
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Comment $comment, EntityManagerInterface $manager){
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commentaire a bien été supprimé"
        );
        return $this->redirectToRoute('admin_comment_index');
    }
}
