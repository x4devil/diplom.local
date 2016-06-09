<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Inventories;
use AppBundle\Form\InventoriesType;

/**
 * Inventories controller.
 *
 * @Route("/inventories")
 */
class InventoriesController extends Controller
{

    /**
     * Lists all Inventories entities.
     *
     * @Route("/", name="inventories")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Inventories')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Inventories entity.
     *
     * @Route("/", name="inventories_create")
     * @Method("POST")
     * @Template("AppBundle:Inventories:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Inventories();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inventories_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Inventories entity.
     *
     * @param Inventories $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Inventories $entity)
    {
        $form = $this->createForm(new InventoriesType(), $entity, array(
            'action' => $this->generateUrl('inventories_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Inventories entity.
     *
     * @Route("/new", name="inventories_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Inventories();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Inventories entity.
     *
     * @Route("/{id}", name="inventories_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Inventories')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inventories entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Inventories entity.
     *
     * @Route("/{id}/edit", name="inventories_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Inventories')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inventories entity.');
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
    * Creates a form to edit a Inventories entity.
    *
    * @param Inventories $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Inventories $entity)
    {
        $form = $this->createForm(new InventoriesType(), $entity, array(
            'action' => $this->generateUrl('inventories_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Сохранить'));

        return $form;
    }
    /**
     * Edits an existing Inventories entity.
     *
     * @Route("/{id}", name="inventories_update")
     * @Method("PUT")
     * @Template("AppBundle:Inventories:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Inventories')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inventories entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('inventories_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Inventories entity.
     *
     * @Route("/{id}", name="inventories_del")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Inventories')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Inventories entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('inventories'));
    }

    /**
     * Creates a form to delete a Inventories entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inventories_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    
     /**
     * Delete inventories entity.
     *
     * @Route("/{id}/delete", name="inventories_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteInventory($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Inventories')->find($id);

        $em->transactional(function($em) use ($entity) {
            $em->remove($entity);
            $em->flush();
        });

        return $this->redirect('/inventories');
    }
}
