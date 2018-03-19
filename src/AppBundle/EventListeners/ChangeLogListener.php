<?php

namespace AppBundle\EventListeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\ChangeLog;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ChangeLogListener implements EventSubscriber
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
            'onDelete',
        );
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        if (!$args->getEntity() instanceof ChangeLog)

            $this->createLog($args, 'creation');
    }


    /**
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postUpdate(LifecycleEventArgs $args)
    {

        $this->createLog($args, 'update');
    }


    /**
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->createLog($args, 'remove');
    }

    /**
     * @param LifecycleEventArgs $args
     * @param $action
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createLog(LifecycleEventArgs $args, $action)
    {
        # Entity manager
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entity = $args->getEntity();

        # Get user
        $user = $this->tokenStorage->getToken()->getUser();

        #Get changes
        $changes = $uow->getEntityChangeSet($entity);

        $cl = new ChangeLog();
        $cl->setDate(new \DateTime());
        $cl->setUser($user);
        $cl->setEntityName(get_class($entity));
        $cl->setEntityId($entity->getId());
        $cl->setAction($action);
        $cl->setDescription('0 - old value, 1 - new value');
        $cl->setChangeset($changes);

        $em->persist($cl);
        $em->flush();
    }
}