<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use AppBundle\Entity\InventoriesRequests;
use AppBundle\Entity\Requests;
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
                ->orderBy('i.id', 'DESC')
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
     * @Route("/inventory{idInventory}", name="show_inventory")
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

        if ($password != $confirmPassword) {
            $responce['message'] = 'Пароли долны совпадать';
            $responce['code'] = 'danger';
            return new JsonResponse(array('responce' => $responce));
        }

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('login' => $login));
        if ($user != null) {
            $responce['message'] = 'Пользователь с таким логином существует';
            $responce['code'] = 'danger';
            return new JsonResponse(array('responce' => $responce));
        }


        $newUser = new User();
//        
        $newUser->setName($fio)
                ->setPhoneNumber($phone)
                ->setLogin($login)
                ->setPassword($password)
                ->setRoles('ROLE_USER');


        $em = $this->getDoctrine()->getManager();
        $em->persist($newUser);
        $em->flush();

        $responce['message'] = 'Поздравляем, теперь вы можете войти на сайт';
        $responce['code'] = 'success';

        return new JsonResponse(array('responce' => $responce));
    }

    /**
     * @Route("/login", name="login")
     * Method("PUT")
     * @Template()
     */
    public function loginAction(Request $request) {
        $login = $request->get('login-login');
        $password = $request->get('login-password');
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('login' => $login, 'password' => $password));

        if (!$user) {
            $responce['message'] = 'Неправильный логин или пароль';
            $responce['code'] = 'danger';
            return new JsonResponse(array('responce' => $responce));
        }

        $session = $this->getRequest()->getSession();
        $session->set('user', $user);

        $responce['message'] = 'Вы вошли на сайт';
        $responce['code'] = 'success';
        $responce['user'] = $user->getName();
        return new JsonResponse(array('responce' => $responce));
    }

    /**
     * @Route("/add/{id}", name="addToCard")
     * Method("PUT")
     * @Template()
     */
    public function addAction($id, Request $request) {
        $session = $this->getRequest()->getSession();
        $card = $session->get('card');
        if ($card == null) {
            $card = new \Doctrine\Common\Collections\ArrayCollection();
        }

        $inventory = $this->getDoctrine()->getRepository('AppBundle:Inventories')->findOneBy(array('id' => $id));
        if ($inventory != null) {
            $flag = true;
            foreach ($card as $c) {
                if ($c->getId() == $id) {
                    echo $c;
                    $flag = false;
                    break;
                }
            }
            if ($flag) {
                $card->add($inventory);
            }
        }
        $session->set('card', $card);
        return $this->redirect($this->generateUrl('show_inventory', array('idInventory' => $id)));
    }

    /**
     * @Route("/del/{id}", name="delFromCard")
     * Method("DELETE")
     * @Template()
     */
    public function delAction($id, Request $request) {
        $session = $this->getRequest()->getSession();
        $card = $session->get('card');

        if ($card != null) {
            $buf = new \Doctrine\Common\Collections\ArrayCollection();
            foreach ($card as $c) {
                if ($c->getId() != $id) {
                    $buf->add($c);
                }
            }
            $session->set('card', $buf);
        }
        return $this->redirect($this->generateUrl('cart'));
    }

    /**
     * @Route("/addrequest", name="addRequest")
     * Method("PUT")
     * @Template()
     */
    public function requestAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $card = $session->get('card');

        if ($card != null) {
            $r = new Requests();
            $r->setDate(new \DateTime());
            $r->setStatus(0);
            $totalPrice = 0;
            foreach ($card as $c) {
                $totalPrice = $c->getPrice();
            }
            $r->setTotalPrice($totalPrice);
            $em = $this->getDoctrine()->getManager();
            $em->persist($r);
            $em->flush();

            foreach ($card as $c) {
                $sql = 'insert into inventories_requests(id_inventory, id_request, date) values(:inv, :req, now())';
                $params = array('inv' => $c->getId(), 'req' => $r->getId());
                
                $query = $em->getConnection()->prepare($sql);
                $query->execute($params);
            }
        }
        $session->set('card', new \Doctrine\Common\Collections\ArrayCollection());
        return $this->redirect($this->generateUrl('cart'));
    }

    /**
     * @Route("/cart", name="cart")
     * Method("GET")
     * @Template()
     */
    public function cardShowAction() {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        $session = $this->getRequest()->getSession();
        $card = $session->get('card');

        return $this->render('default/cart.html.twig', array(
                    'inventories' => $card,
                    'categories' => $categories,
        ));
    }

    public function checkUser() {
        $user = getCurrentUser();
        if (!$user) {
            return false;
        }

        if ($user->getRoles() !== 'ROLE_USER' || $user->getRoles() !== 'ROLE_ADMIN') {
            return false;
        }

        return true;
    }

    public function checkAdmin() {
        $user = getCurrentUser();
        if (!$user) {
            return false;
        }

        if ($user->getRoles() !== 'ROLE_ADMIN') {
            return false;
        }

        return true;
    }

    public function getCurrentUser() {
        $session = $this->getRequest()->getSession();
        $user = $session->get('user');

        return $user;
    }

}
