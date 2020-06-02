<?php

namespace App\Repository;

use App\Entity\ContactPro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactPro|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactPro|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactPro[]    findAll()
 * @method ContactPro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactProRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactPro::class);
    }
	
	public function findContactByPrenom(string $prenom){
		return $this->findBy(array(
			'prenom' => $prenom
		));
	}
	
	public function findContactRecent(\DateTime $date){
		return $this->createQueryBuilder('c')
			->where('c.createdAt > :date')
			->setParameter('date', $date)
			->getQuery()
			->getResult();
	}

    // /**
    //  * @return ContactPro[] Returns an array of ContactPro objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContactPro
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
