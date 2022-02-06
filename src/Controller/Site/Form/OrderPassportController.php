<?php namespace App\Controller\Site\Form;

use App\Controller\ReferenceController;
use App\Entity\Site\Form\OrderPassport;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/order-passport', name: 'order_passport_')]
class OrderPassportController extends ReferenceController
{
    protected string $entityClassName = OrderPassport::class;
}
