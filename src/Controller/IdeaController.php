<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\IdeaType;
use App\Repository\IdeaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/idea", name="idea_")
 */
class IdeaController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(IdeaRepository $ideaRepo)
    {
        $ideas = $ideaRepo->findIdeasWithCategory();
        return $this->render('idea/list.html.twig', ["ideas" => $ideas]);
    }

    /**
     * @Route("/{id}", name="detail", requirements={"id": "\d+"})
     */
    public function detail($id, IdeaRepository $ideaRepo)
    {
        $idea = $ideaRepo->find($id);
        return $this->render('idea/detail.html.twig', ["idea" => $idea]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {
        $idea = new Idea();

        $ideaForm = $this->createForm(IdeaType::class, $idea);

        $ideaForm->handleRequest($request);

        if ($ideaForm->isSubmitted() && $ideaForm->isValid()) {
            $em->persist($idea);
            $em->flush();

            $this->addFlash('success', 'The idea has been saved !');
            return $this->redirectToRoute('idea_detail', ['id' => $idea->getId()]);
        }
        return $this->render('idea/add.html.twig', [
            "ideaForm" => $ideaForm->createView()
        ]);
    }
}
