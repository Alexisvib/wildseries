<?php


namespace App\Controller;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\ProgramType;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

/**
 * @Route("/programs", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig', [
            'website' => 'Wild Séries',
            'programs' => $programs,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, Slugify $slugify, MailerInterface $mailer, EntityManagerInterface $manager): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $program->setOwner($this->getUser());
            $manager->persist($program);
            $manager->flush();

            $email =(new TemplatedEmail())
                ->from($this->getParameter('mailer_from'))
                ->to(new Address('test@gmail.com'))
                ->subject('Nouvelle série publié')
                ->htmlTemplate('program/newProgramEmail.html.twig')
                ->context([
               'program' => $program
            ]);
            $mailer->send($email);

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{slug}/edit", name="edit")
     * @return Response
     */
    public function edit(Program $program, Request $request, EntityManagerInterface $manager): Response
    {
        if(!($this->getUser() === $program->getOwner()) && !(in_array('ROLE_ADMIN',$this->getUser()->getRoles()))) {
            throw new AccessDeniedException('Only the owner can edit this program !');
        }
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('program_index');
        }
        return $this->render('program/edit.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="show")
     * @return Response
     */
    public function show(Program $program):Response
    {

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '. $program->getId(). ' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    /**
     * Getting a season by number
     *
     * @Route("/{slug}/{season}", name="season_show")
     *
     * @return Response
     */
    public function showSeason(Program $program, Season $season): Response
    {
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);

    }


    /**
     * Getting an episode by number
     *
     * @Route("/{program}/{season}/{episode}", name="episode_show")
     * @return Response
     */
    public function showEpisode(Request $request, Program $program, Season $season, Episode $episode, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setEpisode($episode);
            $comment->setAuthor($this->getUser());
            $manager->persist($comment);
            $manager->flush();
        }
        return $this->render('program/episode_show.html.twig', [
            'form'    => $form->createView(),
            'program' => $program,
            'season'  => $season,
            'episode' => $episode,
        ]);

    }



}