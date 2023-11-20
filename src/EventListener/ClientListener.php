<?php

namespace App\EventListener;

use App\Entity\Client;
use App\Entity\Organisation;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postLoad, entity: Client::class)]
#[AsEntityListener(event: Events::preFlush, entity: Client::class)]
readonly class ClientListener
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function postLoad(Client $client, PostLoadEventArgs $event): void
    {
        $this->_loadOrganisation($client);
    }

    public function preFlush(Client $client, PreFlushEventArgs $event): void
    {
        $client->organisationId = $client->getOrganisation()?->getId();
    }

    private function _loadOrganisation(Client $client): void
    {
        $organisation = null;
        if ($client->organisationId) {
            $organisation = $this->entityManager->find(Organisation::class, $client->organisationId);
        }

        $client->setOrganisation($organisation);
    }
}
