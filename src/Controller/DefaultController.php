<?php


namespace App\Controller;
use App\Form\LanguageType;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(Request $request, ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findBy([], ['id' => 'DESC'], 3);
        $form = $this->createForm(LanguageType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $request->setLocale($form->getData()['Choice_Language']);
        }
        return $this->render('index.html.twig', [
            'programs' => $programs,
            'form' => $form->createView(),
        ]);
    }



}