<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{

    private $manager;
    public function __construct(private EtudiantRepository $repository, private ManagerRegistry $doctrine)
    {
        $this->manager = $doctrine->getManager();
    }
    #[Route('/', name: 'app_etudiant')]
    public function load(EtudiantRepository $p): Response
    {   $etudiant=$p->findAll();
        return $this->render('etudiant/index.html.twig', [
            'etudiant' => $etudiant,
        ]);

}
    #[Route('/edit/{id?0}', name: 'app_etudiant_add')]
    public function updateEtudiant(Etudiant $etudiant=null,Request $request)
    {  $r=$this->manager->getRepository(Etudiant::class);
        $new=False;
        if (!$etudiant) {
            $new = true;
            $etudiant = new Etudiant();
        }
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
           $this->manager->persist($etudiant);
           $this->manager->flush();
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash('success',$etudiant->getNom(). $message );
            return $this->redirectToRoute('app_etudiant');
        } else {
            return $this->render('etudiant/add-etudiant.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
#[Route('/delete/{id}',name: 'ap_del')]
    public function deleteEtudiant(Etudiant $etudiant=null): Response
{if(!$etudiant)
{
    $this->addFlash('error',"existe pas");
}
    $this->manager->remove($etudiant);
    $this->manager->flush();
    return $this->redirectToRoute('app_etudiant');}}
