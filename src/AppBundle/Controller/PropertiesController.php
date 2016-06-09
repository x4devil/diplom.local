<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Properties;
use AppBundle\Form\PropertiesType;

/**
 * Properties controller.
 *
 * @Route("/properties")
 */
class PropertiesController extends Controller
{

    /**
     * Lists all Properties entities.
     *
     * @Route("/", name="properties")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Properties')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Properties entity.
     *
     * @Route("/", name="properties_create")
     * @Method("POST")
     * @Template("AppBundle:Properties:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Properties();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('properties_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Properties entity.
     *
     * @param Properties $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Properties $entity)
    {
        $form = $this->createForm(new PropertiesType(), $entity, array(
            'action' => $this->generateUrl('properties_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Properties entity.
     *
     * @Route("/new", name="properties_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Properties();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Properties entity.
     *
     * @Route("/{id}", name="properties_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Properties')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Properties entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Properties entity.
     *
     * @Route("/{id}/edit", name="properties_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Properties')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Properties entity.');
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
    * Creates a form to edit a Properties entity.
    *
    * @param Properties $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Properties $entity)
    {
        $form = $this->createForm(new PropertiesType(), $entity, array(
            'action' => $this->generateUrl('properties_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Properties entity.
     *
     * @Route("/{id}", name="properties_update")
     * @Method("PUT")
     * @Template("AppBundle:Properties:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Properties')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Properties entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('properties_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Properties entity.
     *
     * @Route("/{id}", name="properties_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Properties')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Properties entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('properties'));
    }

    /**
     * Creates a form to delete a Properties entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('properties_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
