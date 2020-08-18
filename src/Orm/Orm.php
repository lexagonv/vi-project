<?php

namespace App\Orm;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class Orm
{
    private $params;
    private $entityManager;

    /**
     * Orm constructor.
     * @param $params
     * @throws ORMException
     */
    public function __construct($params)
    {
        $this->params = $params;

        $config = Setup::createAnnotationMetadataConfiguration(array('src/Entity'), true, null, null, false);
        $entityManager = EntityManager::create($this->params, $config);
        $this->setEntityManager($entityManager);
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }
}