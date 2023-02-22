<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\CategoryRepository;
use App\Services\CategoriesServices;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;


class ContactController extends AbstractController
{
    public function __construct(CategoriesServices $categoriesServices){
        $categoriesServices->updateSession();
    }

    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, CategoryRepository $repoCat, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $session = $request->getSession();

        if($form->isSubmitted() && $form->isValid()){
            $contact->setcreatedAt(new \DateTimeImmutable());
            $em->persist($contact);
            $em->flush();
            $contact = new Contact();
            $form = $this->createForm(ContactType::class, $contact);

            //Email
        //    $email = (new Email())
        //        ->from('hello@exemple.com')
        //        ->to('you@exemple.com')
        //        ->subject('Nouveau message de contact')
        //        ->text('Sending emails is fun again!')
        //        ->html('<p>See Twig integration for better HTML integration!</////p>');
//
        //        $mailer->send($email);

            $session->getFlashBag()->add('message', "Message envoyer avec succès");
            $session->set('status', "success");

        }else if($form->isSubmitted() && ! $form->isValid()){
            $session->getFlashBag()->add('message', "Merci de corriger les erreurs");
            $session->set('status', "danger");
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $form->createView()
        ]);
    }
}
