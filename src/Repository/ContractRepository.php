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
	
	public function findAllJoin()
	{
		return $this->createQueryBuilder('c')
			->addSelect('a', 't')
			->join('c.Apartment', 'a')
			->join('c.Tenant', 't')
			->getQuery()
			->getResult();
	}
	
	public function ContractDesc()
	{
		return $this->createQueryBuilder('c')
			->orderBy('c.id', 'DESC')
			->getQuery()
			->getResult();
	}
	
	public function ApartmentContract(int $id)
	{
		$data = $this->createQueryBuilder('c')
			->addSelect('t')
			->join('c.Tenant', 't')
			->where('c.Apartment = :id')
			->setParameter(':id', $id)
			->getQuery()
			->getResult();
		return $data;
	}
	
	public function TenantContract(int $id)
	{
		$data = $this->createQueryBuilder('c')
			->addSelect('a')
			->join('c.Apartment', 'a')
			->where('c.Tenant = :id')
			->setParameter(':id', $id)
			->getQuery()
			->getResult();
		return $data;
	}
	
	public function contractPayment(int $id){
		return $this->createQueryBuilder('c')
			->addSelect('p','tp')
			->join('c.payments','p')
			->join('c.TypePayment','tp')
			->where('c.id=:id')
			->setParameter(':id',$id)
			->getQuery()
			->getResult();
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
