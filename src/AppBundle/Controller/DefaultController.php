<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller {

    /**
     * @Route("/")
     */
    public function indexAction(Request $request) {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Inventories');
        $query = $repository->createQueryBuilder('i');
        $query = $query
                ->distinct()
                ->orderBy('i.idInventory', 'DESC')
                ->setMaxResults(2)
                ->getQuery();
        $lastInventories = $query->getResult();

        return $this->render('default/index.html.twig', array(
                    'categories' => $categories,
                    'lastInventories' => $lastInventories
        ));
    }

    /**
     * @Route("/category{idCategory}/page{pageId}")
     * Method("GET")
     * @Template()
     */
    public function showCategory($idCategory, $pageId, Request $request) {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $activeCategory = $this->getDoctrine()->getRepository('AppBundle:Category')->find($idCategory);

        $inPage = 6;
        if ($pageId == 1) {
            $offset = 0;
        } else {
            $offset = ($pageId - 1) * $inPage;
        }


        $inventories = $this->getDoctrine()->getRepository('AppBundle:Inventories')->findBy(array('idCategory' => $idCategory));

        $pageCount = count($inventories);
        if ($pageCount != 0) {
            if ($pageCount % $inPage == 0) {
                $pageCount = (int) ($pageCount / $inPage);
            } else {
                $pageCount = (int) ($pageCount / $inPage + 1);
            }
        }

        $inventories = $this->getDoctrine()->getRepository('AppBundle:Inventories')->findBy(
                array('idCategory' => $idCategory), array(), $inPage, $offset);

        return $this->render('default/category.html.twig', array(
                    'categories' => $categories,
                    'inventories' => $inventories,
                    'pageCount' => $pageCount,
                    'activePage' => $pageId,
                    'activeCategory' => $activeCategory
        ));
    }

    /**
     * @Route("/inventory{idInventory}")
     * Method("GET")
     * @Template()
     */
    public function showInventory($idInventory, Request $request) {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        $inventory = $this->getDoctrine()->getRepository('AppBundle:Inventories')->find($idInventory);

        return $this->render('default/inventory.html.twig', array(
                    'categories' => $categories,
                    'inventory' => $inventory
        ));
    }
    
    /**
     * @Route("/register", name="register")
     * Method("PUT")
     * @Template()
     */
    public function registerAction(Request $request) {
        $fio = $request->get('fio');
        $phone = $request->get('phone');
        $login = $request->get('login');
        $password = $request->get('password');
        $confirmPassword = $request->get('confirm-password');
        
        $responce = array();
        if ($password != $confirmPassword) { 
            $responce['message'] =  'Пароли долны совпадать';
            $responce['code'] = 'error';
        }
        
         return new JsonResponse(array('responce' => $responce)); 
    }

}
