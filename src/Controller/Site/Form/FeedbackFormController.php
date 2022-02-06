<?php namespace App\Controller\Site\Form;

use App\Controller\ReferenceController;
use App\Entity\Site\Form\FeedbackForm;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/feedback-form', name: 'feedback_form_')]
class FeedbackFormController extends ReferenceController
{
    protected string $entityClassName = FeedbackForm::class;
}
