<?php namespace App\Controller\Site\Form;

use App\Controller\ReferenceController;
use App\Entity\Site\Form\ObituaryForm;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/obituary-form', name: 'obituary_form_')]
class ObituaryFormController extends ReferenceController
{
    protected string $entityClassName = ObituaryForm::class;
}
