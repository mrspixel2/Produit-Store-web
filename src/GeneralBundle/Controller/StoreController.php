<?php

namespace GeneralBundle\Controller;

use GeneralBundle\Entity\Store;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Store controller.
 *
 * @Route("store")
 */
class StoreController extends Controller
{
    /**
     * Lists all store entities.
     *
     * @Route("/", name="store_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // $stores = $em->getRepository('GeneralBundle:Store')->findAll();
        $stores = $this->getUser()->getStores();
        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $stores,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );
        return $this->render('store/index.html.twig', array(
            'stores' => $result,
        ));
    }

    /**
     * Creates a new store entity.
     *
     * @Route("/new", name="store_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $store = new Store();
        $form = $this->createForm('GeneralBundle\Form\StoreType', $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $store->setOwner($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($store);
            $em->flush();
            $this->addFlash('success','Votre store a été bien enregistrer!');

            return $this->redirectToRoute('store_index', array('id' => $store->getId()));
        }

        return $this->render('store/new.html.twig', array(
            'store' => $store,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/addstore/{owner}/{nom}/{description}", name="addstore")
     */

    public function addStoreAction(Request $request, $owner ,$nom, $description){
        $store = new Store();
        $user = $this->getDoctrine()->getRepository('GeneralBundle:User')->findOneBy(['id'=> $owner]);
        $store->setOwner($user);
        $store->setNom($nom);
        $store->setDescription($description);


        $ex="succes";
        $em = $this->getDoctrine()->getManager();
        $em->persist($store);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);
    }

    /**
     * Finds and displays a store entity.
     *
     * @Route("/{id}", name="store_show")
     * @Method("GET")
     */
    public function showAction(Store $store)
    {
        $deleteForm = $this->createDeleteForm($store);

        return $this->render('store/show.html.twig', array(
            'store' => $store,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing store entity.
     *
     * @Route("/{id}/edit", name="store_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Store $store)
    {
        $deleteForm = $this->createDeleteForm($store);
        $editForm = $this->createForm('GeneralBundle\Form\StoreType', $store);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Votre store a été modifier!');

            return $this->redirectToRoute('store_index', array('id' => $store->getId()));
        }

        return $this->render('store/edit.html.twig', array(
            'store' => $store,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a store entity.
     *
     * @Route("/{id}", name="store_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Store $store)
    {
        $form = $this->createDeleteForm($store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($store);
            $em->flush();
            $this->addFlash('success','Votre a été supprimer!');
        }

        return $this->redirectToRoute('store_index');
    }


    /**
     * Lists all store entities.
     *
     * @Route("/all/store" , name="store_all")
     */
    public function AllStoresAction()
    {
        $Stores = $this->getDoctrine()->getManager()
            ->getRepository('GeneralBundle:Store')
            ->findStores();

        return new JsonResponse($Stores);
    }

    /**
     * Lists all store entities.
     *
     * @Route("/getUserStores/{id}" , name="stores_user")
     */
    public function getUserStoresAction($id)
    {
        $Stores = $this->getDoctrine()->getManager()
            ->getRepository('GeneralBundle:Store')
            ->findStoreByOwner($id);

        return new JsonResponse($Stores);
    }

    /**
     *
     * @Route("/all/login" , name="login")
     */
    public function loginAction(Request $request)
    {

        $username = $request->get("nom");
        $password = $request->get("mdp");


        //  $entityManager = $this->getDoctrine()->getManager();
        //  $user = $this->getUser() ;
        $user = $this->getDoctrine()->getRepository('GeneralBundle:User')->findOneBy(['username' => $username]);
        $encoderService = $this->container->get('security.password_encoder');
        if ($user != null) {
            $match = $encoderService->isPasswordValid($user, $password);
            if ($match == true) {
                $encoder = new JsonEncoder();
                $normalisers = new ObjectNormalizer();
                $normalisers->setCircularReferenceHandler(function ($object) {
                    return $object->getId();
                });
                $serializer = new Serializer([$normalisers,$encoder]);
                $formatted = $serializer->normalize([$user]);
                return new JsonResponse($formatted);
            } else {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize(null);
                return new JsonResponse(123);
            }
        } else {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize(null);
            return new JsonResponse(123);
        }
    }


    /**
     * Creates a form to delete a store entity.
     *
     * @param Store $store The store entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Store $store)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('store_delete', array('id' => $store->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
