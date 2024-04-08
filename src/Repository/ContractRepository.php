<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Entity\Apartment;
use App\Entity\Tenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contract>
 *
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contract::class);
    }

//int $id
		public function apartmentContract(int $id)
		{
			$data = $this->createQueryBuilder('c')
				->addSelect('a')
				->join('c.apartment','a')
				->where('a.id = :id')
				->setParameter(':id', $id)
				->getQuery()
				->getResult();
			return $data;
		}
		
		public function tenantContract(int $id){
			$data = $this->createQueryBuilder('c')
				->addSelect('t')
				->join('c.tenant','t')
				->where('t.id = :id')
				->setParameter(':id',$id)
				->getQuery()
				->getResult();
			return $data;
		}

    //    /**
    //     * @return Contract[] Returns an array of Contract objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Contract
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
