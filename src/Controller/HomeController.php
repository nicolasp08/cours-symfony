<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class HomeController extends AbstractController{


   /**
    * Montre la page hello
    * @Route("/hello", name="hello_base")
    * @Route("/hello/{prenom}", name="hello_prenom")
    * @Route("/bonjour/{prenom}/age/{age}", name="hello")
    * @return void
    */

    public function hello($prenom = "anonyme", $age = 0 ){
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom, 
                'age' => $age
            ]
            );  

        }



    /**
     * @Route("/", name="homepage")
     */

     public function home(){

        $prenoms = ["Nico" => 35, "Mimi" => 63, "Vince" => 36];

         return $this->render(
             'home.html.twig',
             ['title' => 'salut !',
             'age' => 15,
             'tableau' => $prenoms
             ]
         );
     }
}


