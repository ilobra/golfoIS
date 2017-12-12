<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Asmuo;
use AppBundle\Entity\StovejimoAikstele;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PersonalasController extends Controller
{
    /**
     * @Route("personnel/profile", name="profile_personnel")
     */
    public function profileAction()
    {
        $userid = $this->getUser()->getId();
        return $this->redirectToRoute('profile_personnel_show', [ 'id' => $userid ]);

    }

    /**
     * @Route("personnel/profile/{id}", name="profile_personnel_show")
     */
    public function profilePersonnelShow(Asmuo $id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:Asmuo')
            ->find($id);

        $darbuotojas = $em->getRepository('AppBundle:Darbuotojas')->find($id);

        return $this->render('personalas/profile.html.twig', array(
            'asmuo' => $user,
            'personalas' => $darbuotojas,
        ));
    }

    /**
     * @Route("personnel/profile/{id}/edit", name="profile_personnel_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Asmuo $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profilePersonnelEdit(Request $request, Asmuo $id){

        $em = $this->getDoctrine()->getManager();

        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($id);

        $editForm = $this->createForm('AppBundle\Form\PersonalasType', $user);
        $editForm->handleRequest($request);

        $em->persist($user);
        $em->flush();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if($user->getPlainPassword()!=null){
                $password = $this
                ->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('profile_personnel_show', array('id' => $user->getId()));
        }
        return $this->render('personalas/edit.html.twig', array(
            'asmuo' => $user,
            'edit_form' => $editForm->createView(),

        ));
    }

    // STOVĖJIMO AIKŠTELĖS DARBUOTOJŲ FUNKCIJOS

    /**
     * @Route("personnel/stovejimo_aikstele_index", name="stovejimo_aikstele_index")
     */
    public function stovejimoAiksteleIndex(){

        $em = $this->getDoctrine()->getManager();
        $userid = $this->getUser()->getId();
        $user = $em ->getRepository('AppBundle:Asmuo')
            ->find($userid);

        $sql = $em->createQuery('
                    SELECT SA.vietosNr, SA.priskyrimoData, SA.id, A.vardas, A.elPastas
                    FROM AppBundle:StovejimoAikstele SA
                    LEFT JOIN AppBundle:Asmuo A WITH SA.fkAsmuoid=A.id
                    GROUP BY SA.id
            		ORDER BY SA.vietosNr DESC');
        $SVietos = $sql->getResult();

        return $this->render('personalas/stovejimo_aikstele.html.twig', array(
            'vietos' => $SVietos,
            'asmuo' => $user,
        ));
    }

    /**
     * @Route("/personnel/stovejimo_aikstele/{id}/add", name="stovejimo_aikstele_add")
     * @Method({"GET", "POST"})
     */
    public function stovejimoAiksteleAdd(Request $request, StovejimoAikstele $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userid = $this->getUser()->getId();
        $user = $em ->getRepository('AppBundle:Asmuo')->find($userid);

        $aikstele = $em->getRepository('AppBundle:StovejimoAikstele')
            ->find($id);

        $editForm = $this->createForm('AppBundle\Form\StovejimoAiksteleType', $aikstele);
        $editForm->handleRequest($request);
        try {
            $em->persist($aikstele);
            $em->flush();
        }
        catch(\Doctrine\DBAL\DBALException $e)
        {
            $this->addFlash('danger', 'Pasirinktas vartotojas jau turi pirskirtą stovėjimo vietą');
            return $this->redirectToRoute('stovejimo_aikstele_index', array('id' => $userid));
        }
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Vartotojui sėkmingai priskirta vieta');
            return $this->redirectToRoute('stovejimo_aikstele_index', array('id' => $userid));
        }
        return $this->render('personalas/stovejimo_aikstele_add.html.twig', array(
            'aikstele' => $aikstele,
            'asmuo' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/personnel/stovejimo_aikstele/{id}/delete", name="stovejimo_aikstele_delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function stovejimoAiksteleDelete(StovejimoAikstele $id){
        $userid = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();

        $sql = $em->createQuery('
            		UPDATE AppBundle:StovejimoAikstele SA
            		SET SA.priskyrimoData=null, SA.fkAsmuoid=null
            		WHERE SA.id = :id
            ')->setParameter('id', $id);

        $sql->execute();

        return $this->redirectToRoute('stovejimo_aikstele_index', array('id' => $userid));
    }

    // GOLFO AIKŠTYNO DARBUOTOJŲ FUNKCIJOS


}
