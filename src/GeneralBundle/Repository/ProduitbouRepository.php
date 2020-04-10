<?php

namespace GeneralBundle\Repository;

/**
 * ProduitbouRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitbouRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $nom
     * @return mixed
     */
    public function findByNom($nom){
        return $this->createQueryBuilder('p')
            ->andWhere('p.nom like :val')
            ->setParameter('val','%'.$nom.'%')
            ->orderBy('p.id' , 'ASC')
            ->getQuery()
            ->getResult();

    }




    public function findProduitsEnReptureDeStock(){
        return $this->getEntityManager()->createQuery(
            'SELECT p 
                                  FROM GeneralBundle:Produitbou p
                                  WHERE p.QteTotal = 0')->getResult();
    }

    /**
     * @param $idOwner
     * @return mixed
     */
    public function findMyBikes($idOwner)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p
                      FROM GeneralBundle:Produitbou p
                      WHERE  p.idStore IN ( SELECT s.id FROM GeneralBundle:Store s
                                            WHERE  s.owner = :idOwner)'
            )
            ->setParameter('idOwner','%'.$idOwner.'%')
            ->getResult();
    }







}