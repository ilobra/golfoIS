<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Asmuo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Asmuo controller.
 *
 * @Route("asmuo")
 */
class AsmuoController extends Controller
{
    /**
     * Lists all asmuo entities.
     *
     * @Route("/", name="asmuo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $asmuos = $em->getRepository('AppBundle:Asmuo')->findAll();

        return $this->render('asmuo/index.html.twig', array(
            'asmuos' => $asmuos,
        ));
    }

    /**
     * Creates a new asmuo entity.
     *
     * @Route("/new", name="asmuo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $asmuo = new Asmuo();
        $form = $this->createForm('AppBundle\Form\AsmuoType', $asmuo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($asmuo);
            $em->flush();

            return $this->redirectToRoute('asmuo_show', array('id' => $asmuo->getId()));
        }

        return $this->render('asmuo/new.html.twig', array(
            'asmuo' => $asmuo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a asmuo entity.
     *
     * @Route("/{id}", name="asmuo_show")
     * @Method("GET")
     */
    public function showAction(Asmuo $asmuo)
    {
        $deleteForm = $this->createDeleteForm($asmuo);

        return $this->render('asmuo/show.html.twig', array(
            'asmuo' => $asmuo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing asmuo entity.
     *
     * @Route("/{id}/edit", name="asmuo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Asmuo $asmuo)
    {
        $deleteForm = $this->createDeleteForm($asmuo);
        $editForm = $this->createForm('AppBundle\Form\AsmuoType', $asmuo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('asmuo_edit', array('id' => $asmuo->getId()));
        }

        return $this->render('asmuo/edit.html.twig', array(
            'asmuo' => $asmuo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a asmuo entity.
     *
     * @Route("/{id}", name="asmuo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Asmuo $asmuo)
    {
        $form = $this->createDeleteForm($asmuo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($asmuo);
            $em->flush();
        }

        return $this->redirectToRoute('asmuo_index');
    }

    /**
     * Creates a form to delete a asmuo entity.
     *
     * @param Asmuo $asmuo The asmuo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Asmuo $asmuo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('asmuo_delete', array('id' => $asmuo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
