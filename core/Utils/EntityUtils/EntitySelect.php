<?php

namespace Core\Utils\EntityUtils;

use Core\DatabaseManager;
use Doctrine\ORM\EntityRepository;

class EntitySelect
{
    /**
     * @var EntityRepository
     */
    private $repository = null;

    private $entityName = null;
    private $criteria = null;
    private $orderBy = null;
    private $offsetStart = null;
    private $offsetLength = null;

    public static function select($entityName)
    {
        return new self($entityName);
    }

    private function __construct($entityName)
    {
        $this->entityName = $entityName;
        $this->repository = DatabaseManager::getEntityManager()->getRepository($entityName);
    }

    public function findById($id)
    {
        return $this->repository->find($id);
    }

    public function find()
    {
        return $this->repository->findBy($this->criteria, $this->orderBy, $this->offsetLength, $this->offsetStart);
    }

    public function findOne()
    {
        return $this->repository->findOneBy($this->criteria, $this->orderBy);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function criteria(array $criteria)
    {
        $this->criteria = $criteria;
    }

    public function orderBy(array $orderBy)
    {
        $this->orderBy = $orderBy;
    }

    public function offsetStart($offsetStart)
    {
        $this->offsetStart = $offsetStart;
    }

    public function offsetLength($offsetLength)
    {
        $this->offsetLength = $offsetLength;
    }
}