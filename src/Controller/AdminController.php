<?php


namespace App\Controller;


use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

class AdminController extends EasyAdminController
{

    public function LinkAction()
    {
        $id = $this->request->query->get('id');

        return $this->redirectToRoute("attendance", ["course" => $id]);


    }
}