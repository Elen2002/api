<?php

namespace App\Controller;

use App\Entity\Loans;
use App\Form\LoansType;
use App\Interfaces\LoansInterface;
use App\Repository\LoansRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/loans', name: 'app_loans_')]
class LoansController extends AbstractController
{


    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request, LoansInterface $loansService): Response
    {
        $params = array_merge($request->request->all(), $request->query->all());
        if ($request->getMethod() === 'POST') {
            $result = $loansService->addEdit($params);
        } else {
            $result = $loansService->list($params);
        }

        $res = new JsonResponse($result);
        return $res;

    }//end index()


    #[Route('/{id}', name: 'change', methods: ['GET', 'PUT', 'DELETE'])]
    public function edit($id, Request $request, LoansInterface $loansService): Response
    {
        $params = array_merge($request->request->all(), $request->query->all());
        if ($request->getMethod() === 'GET') {
            $result = $loansService->show($id);
        } else if ($request->getMethod() === 'PUT') {
            $result = $loansService->addEdit($params, $id);
        } else {
            $result = $loansService->delete($id);
        }

            $res = new JsonResponse($result);
        return $res;

    }//end edit()


}//end class
