<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Attribute\Cache;
use App\Form\PeopleType;
use App\Form\ClearSessionType;
use App\CustomClass\GenericClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeopleController extends GenericClass
{
    #[Cache(expires: 'tomorrow', public: true)]
    #[Route('/people', name: 'people')]
    public function index(Request $request): Response
    {
        $clearSessionForm = $this->createForm(ClearSessionType::class);
        $clearSessionForm->handleRequest($request);

        $peopleForm = $this->createForm(PeopleType::class);        
        $peopleForm->handleRequest($request);
        
        $session = $this->requestStack->getSession();
        
        if ($clearSessionForm->isSubmitted() && $clearSessionForm->isValid()) {
            $session->clear();
        }
        
        if ($session->get('name')) {
            $people = $this->GetPeopleByName($session->get('name'), $session->get('languagePeople'));
        }
        else{
            $people = $this->GetPopularPeople();
            $clearSessionForm=null;
        }

        if ($peopleForm->isSubmitted() && $peopleForm->isValid()) {
            $formData = $peopleForm->getData();

            if ($formData['honeypot']) {
                return $this->redirectToRoute('index');
            }

            $session->set('name', $formData['name']);
            $session->set('languagePeople', $formData['language']);

            $people = $this->GetPeopleByName($formData['name'], $formData['language']);

            $clearSessionForm = $this->createForm(ClearSessionType::class);
            $clearSessionForm->handleRequest($request);
        }

        return $this->render('people/index.html.twig', [
            'peopleForm' => $peopleForm->createView(),
            'clearSessionForm' => $clearSessionForm?$clearSessionForm->createView():null,
            'people' => $people,
        ]);
    }
}
