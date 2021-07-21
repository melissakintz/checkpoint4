<?php

namespace App\Controller;

use App\Entity\Compilation;
use App\Form\CompilationType;
use App\Repository\CompilationRepository;
use App\Service\Extractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/compilation", name="compilation_"))
 */
class CompilationController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CompilationRepository $compilationRepository): Response
    {
        return $this->render('user/compilation/index.html.twig', [
            'compilations' => $compilationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, Extractor $extractor): Response
    {
        $compilation = new Compilation();
        $form = $this->createForm(CompilationType::class, $compilation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(!empty($form->get('youtube')->getData()[1])){
                //extract id from youtube video
                $youtubeLinks = $form->get('youtube')->getData();
                $ytIds[] = $extractor->extractYoutube($youtubeLinks);
                $compilation->setYoutubeLinks($ytIds);
            }

            if(!empty($form->get('spotify')->getData()[1])) {
                //explode spotify links to array
                $spotifyLinks = $form->get('spotify')->getData();
                $spotifyILinks = $extractor->toArray($spotifyLinks);
                $compilation->setSpotifyLinks($spotifyILinks);
            }

            $date = new \DateTime('now');
            $compilation->setDate($date);
            $compilation->setCreator($this->getUser());

            //send in base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compilation);
            $entityManager->flush();

            return $this->redirectToRoute('compilation/index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/compilation/new.html.twig', [
            'compilation' => $compilation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Compilation $compilation): Response
    {
        return $this->render('user/compilation/show.html.twig', [
            'compilation' => $compilation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Compilation $compilation): Response
    {
        $form = $this->createForm(CompilationType::class, $compilation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/compilation/edit.html.twig', [
            'compilation' => $compilation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Compilation $compilation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compilation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($compilation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @param Compilation $compilation
     * @Route("/like/{compilation}", name="like")
     */
    public function like(Compilation $compilation){
        $this->getUser()->addLikedCompilation($compilation);
        $compilation->addLike($this->getUser());
    }
}
