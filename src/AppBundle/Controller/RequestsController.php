<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Requests;
use AppBundle\Form\RequestsType;

/**
 * Requests controller.
 *
 * @Route("/requests")
 */
class RequestsController extends Controller
{

    /**
     * Lists all Requests entities.
     *
     * @Route("/", name="requests")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Requests')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Requests entity.
     *
     * @Route("/", name="requests_create")
     * @Method("POST")
     * @Template("AppBundle:Requests:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Requests();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('requests_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Requests entity.
     *
     * @param Requests $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Requests $entity)
    {
        $form = $this->createForm(new RequestsType(), $entity, array(
            'action' => $this->generateUrl('requests_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Requests entity.
     *
     * @Route("/new", name="requests_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Requests();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Requests entity.
     *
     * @Route("/{id}", name="requests_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Requests')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requests entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Requests entity.
     *
     * @Route("/{id}/edit", name="requests_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Requests')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requests entity.');
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
    * Creates a form to edit a Requests entity.
    *
    * @param Requests $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Requests $entity)
    {
        $form = $this->createForm(new RequestsType(), $entity, array(
            'action' => $this->generateUrl('requests_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Requests entity.
     *
     * @Route("/{id}", name="requests_update")
     * @Method("PUT")
     * @Template("AppBundle:Requests:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Requests')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Requests entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('requests_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Requests entity.
     *
     * @Route("/{id}", name="requests_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Requests')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Requests entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('requests'));
    }

    /**
     * Creates a form to delete a Requests entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('requests_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
