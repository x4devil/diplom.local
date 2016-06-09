<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\InventoriesRequests;
use AppBundle\Form\InventoriesRequestsType;

/**
 * InventoriesRequests controller.
 *
 * @Route("/inventoriesrequests")
 */
class InventoriesRequestsController extends Controller
{

    /**
     * Lists all InventoriesRequests entities.
     *
     * @Route("/", name="inventoriesrequests")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:InventoriesRequests')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new InventoriesRequests entity.
     *
     * @Route("/", name="inventoriesrequests_create")
     * @Method("POST")
     * @Template("AppBundle:InventoriesRequests:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new InventoriesRequests();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventoriesrequests_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a InventoriesRequests entity.
     *
     * @param InventoriesRequests $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(InventoriesRequests $entity)
    {
        $form = $this->createForm(new InventoriesRequestsType(), $entity, array(
            'action' => $this->generateUrl('inventoriesrequests_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new InventoriesRequests entity.
     *
     * @Route("/new", name="inventoriesrequests_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new InventoriesRequests();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a InventoriesRequests entity.
     *
     * @Route("/{id}", name="inventoriesrequests_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InventoriesRequests')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InventoriesRequests entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing InventoriesRequests entity.
     *
     * @Route("/{id}/edit", name="inventoriesrequests_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InventoriesRequests')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InventoriesRequests entity.');
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
    * Creates a form to edit a InventoriesRequests entity.
    *
    * @param InventoriesRequests $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(InventoriesRequests $entity)
    {
        $form = $this->createForm(new InventoriesRequestsType(), $entity, array(
            'action' => $this->generateUrl('inventoriesrequests_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing InventoriesRequests entity.
     *
     * @Route("/{id}", name="inventoriesrequests_update")
     * @Method("PUT")
     * @Template("AppBundle:InventoriesRequests:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:InventoriesRequests')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InventoriesRequests entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('inventoriesrequests_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a InventoriesRequests entity.
     *
     * @Route("/{id}", name="inventoriesrequests_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:InventoriesRequests')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find InventoriesRequests entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('inventoriesrequests'));
    }

    /**
     * Creates a form to delete a InventoriesRequests entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inventoriesrequests_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
