<?php

namespace FF\FastBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * IngredientsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCommentaire($page, $nbPerPage)
  {
    $query = $this->createQueryBuilder('a')
      ->getQuery()
    ;

    $query
      // On définit l'annonce à partir de laquelle commencer la liste
      ->setFirstResult(($page-1) * $nbPerPage)
      // Ainsi que le nombre d'annonce à afficher sur une page
      ->setMaxResults($nbPerPage)
    ;

    // Enfin, on retourne l'objet Paginator correspondant à la requête construite
    // (n'oubliez pas le use correspondant en début de fichier)
    return new Paginator($query, true);
  }
  public function getbyDate($date)
  {
      
       $query = $this->createQueryBuilder('a')
      ->select('COUNT(a)')
      ->Where('a.date > :date_start')
      ->andWhere('a.date < :date_end')
      ->setParameter('date_start', $date->format('Y-m-d 00:00:00'))
      ->setParameter('date_end',   $date->format('Y-m-d 23:59:59'))     
      ->getQuery()
      ->getSingleScalarResult();
    ;


    return($query);
  }
  
  
    public function getbyDatenc($date)
  {
      
       $query = $this->createQueryBuilder('a')
      ->Where('a.date > :date_start')
      ->andWhere('a.date < :date_end')
      ->setParameter('date_start', $date->format('Y-m-d 00:00:00'))
      ->setParameter('date_end',   $date->format('Y-m-d 23:59:59'))     
      ->getQuery()
    ;


    return($query->getResult());
  }
}
