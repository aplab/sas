<?php namespace App\Controller\Site\Form;

use App\Controller\ReferenceController;
use App\Entity\Site\Form\OrderForm;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/order-form', name: 'order_form_')]
class OrderFormController extends ReferenceController
{
    protected string $entityClassName = OrderForm::class;
}
