<?php

namespace App\Services;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CategoriesServices{
    private $repoCat;
    private $requestStack;


    public function __construct(RequestStack $requestStack, CategoryRepository $repoCat){
        $this->requestStack = $requestStack;
        $this->repoCat = $repoCat;
    }

    public function updateSession(){
        $session = $this->requestStack->getSession();
        $categories = $this->repoCat->findAll();
        $session->set("categories", $categories);
    }
}