<?php

namespace App\Services;

use App\Entity\Loans;
use App\Form\LoansType;
use App\Interfaces\LoansInterface;
use App\Repository\LoansRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoansService implements LoansInterface
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }//end __construct()


    /**
     * @param  array $params
     * @param  $id
     * @return string[]
     */
    public function addEdit(array $params, $id='')
    {
        if (empty($id) === false) {
            /*
             * @var LoansRepository $repo
             */
            $repo      = $this->em->getRepository(Loans::class);
            $loansList = $repo->getLoans();
            $ids       = array_column($loansList, 'id');
            $result    = in_array($id, $ids);
            if ($result === false) {
                return [
                    'status'  => 'ok',
                    'message' => 'Nothing found with this id',
                ];
            } else {
                $loans = $this->em->getRepository(Loans::class)->find($id);
            }
        } else {
            $loans       = new Loans();
            $creatonDate = new \DateTime();
            $loans->setCreationDate($creatonDate);
        }//end if

        if (empty($params['amount']) === true) {
            $result = [
                'status'  => 'error',
                'message' => 'Amount is missing',
            ];
            return $result;
        } else {
            $loans->setAmount($params['amount']);
            $percent = ($params['amount'] * 10 / 100);
            $loans->setPercent($percent);
            $this->em->persist($loans);
            $this->em->flush();
            $result = [
                'status'  => 'ok',
                'message' => 'Successfully done',
            ];
        }

        return $result;

    }//end addEdit()


    /**
     * @param  array $params
     * @return mixed
     */
    public function list(array $params)
    {
        /*
         * @var LoansRepository $repo
         */
        $repo = $this->em->getRepository(Loans::class);
        if (empty($params) === false) {
            $loans = $repo->getLoans($params);
        } else {
            $loans = $repo->getLoans();
        }

        return $loans;

    }//end list()


    /**
     * @param  integer $id
     * @return array
     */
    public function delete(int $id)
    {
        $loan = $this->em->getRepository(Loans::class)->find($id);
        $this->em->remove($loan);
        $this->em->flush();
        return [
            'status'  => 'ok',
            'message' => 'Successfully deleted',
        ];

    }//end delete()


    /**
     * @param  int $id
     * @return mixed
     */
    public function show(int $id)
    {
        /*
         * @var LoansRepository $repo
         */
        $repo   = $this->em->getRepository(Loans::class);
        $loans  = $repo->getLoans();
        $ids    = array_column($loans, 'id');
        $result = in_array($id, $ids);
        if ($result === false) {
            return [
                'status'  => 'ok',
                'message' => 'this id not found',
            ];
        } else {
            $loan = $repo->getLoan($id);
            return [
                'status'  => 'ok',
                'message' => $loan,
            ];
        }

    }//end show()


}//end class
