<?php

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Payment>
 *
 * @method Payment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payment[]    findAll()
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Payment::class);
	}

//		public function findId(int $id){
//			$data = $this->createQueryBuilder('p')
//				->addSelect('c')
//				->join('p.contract','c')
//				->where('c.id=:id')
//				->setParameter(':id',$id)
//				->getQuery()
//				->getResult();
//			return $data;
	public function contractPayment(int $id){
		$data = $this->createQueryBuilder('p')
			->addSelect('c','pt')
			->join('p.contract','c')
			->join('p.paymentType','pt')
			->where('c.id=:id')
			->setParameter('id',$id)
			->getQuery()
			->getResult();
		
		return $data;
	}
	
	//    /**
	//     * @return Payment[] Returns an array of Payment objects
	//     */
	//    public function findByExampleField($value): array
	//    {
	//        return $this->createQueryBuilder('p')
	//            ->andWhere('p.exampleField = :val')
	//            ->setParameter('val', $value)
	//            ->orderBy('p.id', 'ASC')
	//            ->setMaxResults(10)
	//            ->getQuery()
	//            ->getResult()
	//        ;
	//    }
	
	//    public function findOneBySomeField($value): ?Payment
	//    {
	//        return $this->createQueryBuilder('p')
	//            ->andWhere('p.exampleField = :val')
	//            ->setParameter('val', $value)
	//            ->getQuery()
	//            ->getOneOrNullResult()
	//        ;
	//    }
}
