<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\InventoriesProperties;
use AppBundle\Form\InventoriesPropertiesType;

/**
 * InventoriesProperties controller.
 *
 * @Route("/inventoriesproperties")
 */
class InventoriesPropertiesController extends Controller
{

    /**
     * Lists all InventoriesProperties entities.
     *
     * @Route("/", name="inventoriesproperties")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:InventoriesProperties')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new InventoriesProperties entity.
     *
     * @Route("/", name="inventoriesproperties_create")
     * @Method("POST")
     * @Template("AppBundle:InventoriesProperties:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new InventoriesProperties();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventoriesproperties_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a InventoriesProperties entity.
     *
     * @param InventoriesProperties $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(InventoriesProperties $entity)
    {
        $form = $this->createForm(new InventoriesPropertiesType(), $entity, array(
            'action' => $this->generateUrl('inventoriesproperties_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new InventoriesProperties entity.
     *
     * @Route("/new", name="inventoriesproperties_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new InventoriesProperties();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a InventoriesProperties entity.
     *
     * @Route("/{id}", name="inventoriesproperties_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InventoriesProperties')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InventoriesProperties entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing InventoriesProperties entity.
     *
     * @Route("/{id}/edit", name="inventoriesproperties_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InventoriesProperties')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InventoriesProperties entity.');
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
    * Creates a form to edit a InventoriesProperties entity.
    *
    * @param InventoriesProperties $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(InventoriesProperties $entity)
    {
        $form = $this->createForm(new InventoriesPropertiesType(), $entity, array(
            'action' => $this->generateUrl('inventoriesproperties_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing InventoriesProperties entity.
     *
     * @Route("/{id}", name="inventoriesproperties_update")
     * @Method("PUT")
     * @Template("AppBundle:InventoriesProperties:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InventoriesProperties')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InventoriesProperties entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('inventoriesproperties_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a InventoriesProperties entity.
     *
     * @Route("/{id}", name="inventoriesproperties_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:InventoriesProperties')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find InventoriesProperties entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('inventoriesproperties'));
    }

    /**
     * Creates a form to delete a InventoriesProperties entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inventoriesproperties_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
