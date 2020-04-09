<?php

namespace GeneralBundle\Controller;

use GeneralBundle\Entity\Notification;
use GeneralBundle\Entity\Produitbou;
use GeneralBundle\Form\ProduitbouType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Produitbou controller.
 *
 * @Route("produitbou")
 */
class ProduitbouController extends Controller
{
    /**
     * Lists all produitbou entities.
     *
     * @Route("/", name="produitbou_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$produitbous = $em->getRepository('GeneralBundle:Produitbou')->findAll();
        $dql = "SELECT pb FROM GeneralBundle:Produitbou pb";
        $query = $em->createQuery($dql);

        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );

        return $this->render('produitbou/index.html.twig', array(
            'produitbous' => $result,
        ));
    }

    public function ProductsByStoreAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if($request->isMethod("post"))
        {
            $storeid = $em->getRepository('GeneralBundle:Store')->findStoreByName($request->get("search"));
            $produitbous = $em->getRepository('GeneralBundle:Produitbou')->findBikeByStore($storeid);

        }


        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $produitbous,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );

        return $this->render('produitbou/index.html.twig', array(
            'produitbous' => $result,
        ));
    }

    public function produitsEnReptureDeStockAction(Request $request){
        $em=$this->getDoctrine()->getManager();

        $produitbou=$em->getRepository('ProduitBundle:Produit')->findProduitsEnReptureDeStock();
        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $produitbou,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );
        return $this->render('produitbou/produitsEnReptureDeStock.html.twig',array('produits'=>$result));
    }

    /**
     *
     * @Route("/ajouter")
     * @Method("POST")
     */
    public function ajouterProduitAction(Request $request)
    {
        $produit=new Produitbou();
        $user = $this->getUser();
        $form=$this->createForm(ProduitbouType::class,$produit,array('user' => $this->getUser()));
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            /** @var UploadedFile $file */
            $file = $produit->getImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$filename
            );
            $produit->setImage($filename);
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produitbou_afficher',  array('id' => $produit->getId()));
        }
        return $this->render('produitbou/new.html.twig', array(
            'produitbou' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produitbou entity.
     *
     * @Route("/{id}", name="produitbou_show")
     * @Method("GET")
     */
    public function showAction(Produitbou $produitbou)
    {
        $deleteForm = $this->createDeleteForm($produitbou);

        return $this->render('produitbou/show.html.twig', array(
            'produitbou' => $produitbou,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a produitbou entity.
     *
     * @Route("/{id}/afficher", name="produitbou_afficher")
     * @Method("GET")
     */
    public function afficherPAction(Produitbou $produitbou)
    {
        $deleteForm = $this->createDeleteForm($produitbou);

        return $this->render('produitbou/afficherProduit.html.twig', array(
            'produitbou' => $produitbou,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produitbou entity.
     *
     * @Route("/{id}/edit", name="produitbou_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produitbou $produitbou)
    {
        $deleteForm = $this->createDeleteForm($produitbou);
        $editForm = $this->createForm('GeneralBundle\Form\ProduitbouType', $produitbou);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produitbou_edit', array('id' => $produitbou->getId()));
        }

        return $this->render('produitbou/edit.html.twig', array(
            'produitbou' => $produitbou,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produitbou entity.
     *
     * @Route("/{id}", name="produitbou_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produitbou $produitbou)
    {
        $form = $this->createDeleteForm($produitbou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produitbou);
            $em->flush();
        }

        return $this->redirectToRoute('produitbou_index');
    }



    /**
     * Creates a form to delete a produitbou entity.
     *
     * @param Produitbou $produitbou The produitbou entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produitbou $produitbou)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produitbou_delete', array('id' => $produitbou->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
