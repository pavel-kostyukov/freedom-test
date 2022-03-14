<?php

namespace App\Controller;

use App\Contracts\CurrenciesLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController
{
    private CurrenciesLoader $currenciesLoader;

    public function __construct(CurrenciesLoader $currenciesLoader)
    {
        $this->currenciesLoader = $currenciesLoader;
    }

    #[Route('/currency', name: 'app_currency')]
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('date', DateType::class, ['label' => 'Дата'])
            ->add('currency_code', TextType::class, [
                'label' => 'Код валюты',
            ])
            ->add('currency_base_code', TextType::class, [
                'label' => 'Код базовой валюты',
                'data' => 'RUR'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Узнать курс'
            ])
            ->setMethod('GET')
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $this->currenciesLoader->getCurrencyValueByDate(new \DateTime());
        }

        return $this->renderForm('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
            'form' => $form,
        ]);
    }
}
