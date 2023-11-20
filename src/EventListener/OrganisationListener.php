<?php

namespace App\EventListener;

use App\Entity\Client;
use App\Entity\Organisation;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postLoad, entity: Organisation::class)]
#[AsEntityListener(event: Events::preFlush, entity: Organisation::class)]
readonly class OrganisationListener
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function postLoad(Organisation $organisation, PostLoadEventArgs $event): void
    {
        $this->_loadClients($organisation);
    }

    public function preFlush(Organisation $organisation, PreFlushEventArgs $event): void
    {
        foreach ($organisation->getClients() as $client) {
            $client->setOrganisation($organisation);
        }
    }

    private function _loadClients(Organisation $organisation): void
    {
        $clients = $this->entityManager
            ->getRepository(Client::class)
            ->findBy(['organisationId' => $organisation->getId()])
        ;

        foreach ($clients as $client) {
            $organisation->addClient($client);
        }
    }
}
