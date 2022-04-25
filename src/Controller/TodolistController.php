<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodolistController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $request): Response
    {   $session = $request->getSession();
        //Initilialize le tableua de todo s'il n'existe pas
        if (!$session->has('todos')){
            $todos=[
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'corraction'=>'corriger mes examens'
            ];
            $session_>set('todos',$todos);
            $this->addFlash('info',"La liste des todos vient d'être initialisée");
        }
        //Si j'ai mon tableu de todo dans ma session je ne fais que l'afficher

        return $this->render('todolist/index.html.twig');
    }
    #[Route('/todo/add/{name}/{content}', name: 'todo.add')]

    public function addTodo(Request $request , $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        //Verifier si j'ai mon tableu de todo dans la session
        if ($session->has('todos'))
        {//si oui 
        $todos=$session->get('todos');
        if (isset($todos[$name])){
            $this->addFlash('error',"Le todo $name existe déjà");
        } else {
            $todos[$name]=$content; //php standard
            $this->addFlash('sucess',"Le ToDo d'id $name vient d'être ajouté avec succès");
            $session->set('todos',$todos);
        }
       }else{
        //si non afficher errreur et rediriger vers le controleur
        $this->addFlash('danger',"La liste des todos n'est pas encore initialisée");
    }
        return $this->redirectToRoute('todo');

    }
    #[Route('/todo/update/{name}/{content}', name: 'todo.update')]

    public function updateTodo(Request $request , $name, $content){
        $session = $request->getSession();
        //Verifier si j'ai mon tableu de todo dans la session
        if ($session->has('todos'))
        {//si oui 
        $todos=$session->get('todos');
        if (!isset($todos[$name])){
            $this->addFlash('error',"Le todo $name n'existe pas dans la liste");
        } else {
            $todos[$name]=$content; //php standard
            $this->addFlash('sucess',"Le ToDo d'id $name a été modifié avec succès");
            $session->set('todos',$todos);
        }
       }else{
        //si non afficher errreur et rediriger vers le controleur
        $this->addFlash('danger',"La liste des todos n'est pas encore initialisée");
    }
        return $this->redirectToRoute('todo');
}

#[Route('/todo/delete/{name}/{content}', name: 'todo.delete')]

    public function deleteTodo(Request $request , $name){
        $session = $request->getSession();
        if (!isset($todos[$name])){
            $this->addFlash('error',"Le todo $name existe déjà");
        } else {
            unset($todos[$name]);
            $this->addFlash('sucess',"Le ToDo d'id $name vient d'être supprimé avec succès");
            $session->set('todos',$todos);
        }
        //si non afficher errreur et rediriger vers le controleur
        $this->addFlash('danger',"La liste des todos n'est pas encore initialisée");
    
        return $this->redirectToRoute('todo');
}
#[Route('/todo/reset/{name}/{content}', name: 'todo.reset')]

    public function resetTodo(Request $request ){
       $session =$request->getSession();
       $session->remove('todos');
        return $this->redirectToRoute('todo');
}

}