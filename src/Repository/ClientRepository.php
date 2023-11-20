<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function filterQb(Client $data = new Client()): QueryBuilder
    {
        $qb = $this->createQueryBuilder('client');

        if ($data->getFirstname()) {
            $qb
                ->andWhere('client.firstname LIKE :firstname')
                ->setParameter('firstname', '%' . $data->getFirstname() . '%')
            ;
        }

        if ($data->getLastname()) {
            $qb
                ->andWhere('client.lastname LIKE :lastname')
                ->setParameter('lastname', '%' . $data->getLastname() . '%')
            ;
        }

        if ($data->getAge()) {
            $qb
                ->andWhere('client.age LIKE :age')
                ->setParameter('age', '%' . $data->getAge() . '%')
            ;
        }

        return $qb;
    }
}
