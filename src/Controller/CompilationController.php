<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Compilation;
use App\Form\CommentType;
use App\Form\CompilationType;
use App\Repository\CompilationRepository;
use App\Service\Extractor;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @isGranted("ROLE_USER")
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
                $spotifyILinks = $extractor->extractSpotify($spotifyLinks);
                $compilation->setSpotifyLinks($spotifyILinks);
            }

            //get image
            if(!empty($form->get('pictures')->getData()[1])){
                $pictures = $form->get('pictures')->getData();
                $picturesName = [];
                foreach($pictures as $picture){
                    // On génère un nouveau nom de fichier
                    $fichier = md5(uniqid()).'.'.$picture->guessExtension();
                    // On copie le fichier dans le dossier uploads
                    $picture->move(
                        $this->getParameter('upload_directory'),
                        $fichier
                    );
                    $picturesName[] = $fichier;
                }
                $compilation->setPictures($picturesName);
            }

            $date = new \DateTime('now');
            $compilation->setDate($date);
            $compilation->setCreator($this->getUser());

            //send in base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compilation);
            $entityManager->flush();

            return $this->redirectToRoute('compilation_show', ['id' => $compilation->getId()], Response::HTTP_SEE_OTHER);
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
     * @Route("/{compilation}/comments", name="comments", methods={"GET", "POST"})
     * @isGranted("ROLE_USER")
     */
    public function comments(Compilation $compilation, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());

            $date = new DateTime('now');
            $comment->setDate($date);
            $comment->setCompilation($compilation);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('compilation_comments', ["compilation" => $compilation->getId()]);
        }

        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['compilation' => $compilation]);

        return $this->render('user/compilation/show_comments.html.twig', [
            'comments' => $comments,
            'compilation' => $compilation,
            'form' => $form->createView()
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
     * @isGranted("ROLE_USER")
     */
    public function delete(Request $request, Compilation $compilation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compilation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($compilation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('board', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @param Compilation $compilation
     * @return Response
     * @Route("/like/{compilation}", name="like")
     * @isGranted("ROLE_USER")
     */
    public function like(Compilation $compilation): Response
    {
        if(!$this->getUser()->isLiked($compilation)){
            $this->getUser()->addLikedCompilation($compilation);
            $compilation->addLike($this->getUser());
        }else{
            $this->getUser()->removeLikedCompilation($compilation);
            $compilation->removeLike($this->getUser());
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->json(['isLiked' => $this->getUser()->isLiked($compilation)]);
    }
}
