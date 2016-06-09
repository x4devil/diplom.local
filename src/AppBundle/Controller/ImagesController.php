<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Images;
use AppBundle\Form\ImagesType;

/**
 * Images controller.
 *
 * @Route("/images")
 */
class ImagesController extends Controller
{

    /**
     * Lists all Images entities.
     *
     * @Route("/", name="images")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Images')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Images entity.
     *
     * @Route("/", name="images_create")
     * @Method("POST")
     * @Template("AppBundle:Images:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Images();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('images_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Images entity.
     *
     * @param Images $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Images $entity)
    {
        $form = $this->createForm(new ImagesType(), $entity, array(
            'action' => $this->generateUrl('images_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Images entity.
     *
     * @Route("/new", name="images_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Images();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Images entity.
     *
     * @Route("/{id}", name="images_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Images')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Images entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Images entity.
     *
     * @Route("/{id}/edit", name="images_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Images')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Images entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Images entity.
    *
    * @param Images $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Images $entity)
    {
        $form = $this->createForm(new ImagesType(), $entity, array(
            'action' => $this->generateUrl('images_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Images entity.
     *
     * @Route("/{id}", name="images_update")
     * @Method("PUT")
     * @Template("AppBundle:Images:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Images')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Images entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('images_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Images entity.
     *
     * @Route("/{id}", name="images_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Images')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Images entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('images'));
    }

    /**
     * Creates a form to delete a Images entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('images_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
