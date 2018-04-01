<?php

namespace AppBundle\EventListeners;

use AppBundle\Entity\AttrValue;
use AppBundle\Entity\Item;
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

    /**
     * ChangeLogListener constructor.
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
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
        if ($args->getEntity() instanceof AttrValue) {
            $this->createLog($args, 'creation');
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof AttrValue) {
            $this->createLog($args, 'update');
        }
    }


    /**
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof AttrValue) {
            $this->createLog($args, 'remove');
        }
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
        //$user = $this->tokenStorage->getToken()->getUser();

        #Get changes
        $data = $uow->getEntityChangeSet($entity);

        //$changes = $this->parseData($data);
        foreach ($data as $field => $value) {

            $oldValue = $value[0];
            $newValue = $value[1];

            /*if ($value[0] instanceof \DateTime)
                $oldValue = $value[0]->format('Y-m-d H:i:s');
            if ($value[1] instanceof \DateTime)
                $newValue = $value[1]->format('Y-m-d H:i:s');
            if ($value[0] instanceof Item)
                $oldValue = $value[0]->getName();
            if ($value[1] instanceof Item)
                $newValue = $value[1]->getName();
            if ($value[0] instanceof Attribute)
                $oldValue = $value[0]->getName();
            if ($value[1] instanceof Attribute)
                $newValue = $value[1]->getName();*/

            if ($value[0] instanceof Item || $value[1] instanceof Item) {
                return;
            }

            $cl = new ChangeLog();
            $cl->setDate(new \DateTime());
            $cl->setUser('user');
            $cl->setEntityName(get_class($entity));
            $cl->setEntityId($entity->getId());
            $cl->setAction($action);
            $cl->setFieldName($field);
            $cl->setOldValue($oldValue);
            $cl->setNewValue($newValue);

            $em->persist($cl);
            $em->flush();
        }
    }
}

