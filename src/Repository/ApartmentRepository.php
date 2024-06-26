<?php

namespace App\Repository;

use App\Entity\Apartment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Apartment>
 *
 * @method Apartment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apartment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apartment[]    findAll()
 * @method Apartment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apartment::class);
    }
		
		public function ApartmentDesc(){
			return $this->createQueryBuilder('a')
				->orderBy('a.id', 'DESC')
				->getQuery()
				->getResult();
		}
		
		public function OwnerApartment(int $id){
			$data = $this->createQueryBuilder('a')
				->addSelect( 'o')
				->join('a.Owner', 'o')
				->where('o.id = :id')
				->setParameter('id', $id)
				->getQuery()
				->getResult();
			return $data;
		}
		
		public function ContractApartment(int $id){
			$data = $this->createQueryBuilder('a')
				->addSelect('c')
				->join('a.contracts','c')
				->where('c.id= :id')
				->setParameter('id',$id)
				->getQuery()
				->getResult();
			return $data;
		}
		
    //    /**
    //     * @return Apartment[] Returns an array of Apartment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Apartment
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
