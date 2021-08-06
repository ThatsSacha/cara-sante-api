<?php

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractRestService {
    private $repository;
    private $className;
    private $denormalizer;
    private $emi;
    private $serializer;

    public function __construct(ServiceEntityRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer)
    {
        $this->repository = $repository;
        $this->className = $repository->getClassName();
        $this->denormalizer = $denormalizer;
        $this->emi = $emi;
    }

    /**
     * @return string $className
     */
    public function getClassName(): string {
        return $this->className;
    }

    public function findBy(array $criteria) {
        return $this->repository->findBy($criteria);
    }

    public function findAll() {
        return $this->repository->findAll();
    }

    public function create(array $data) {
        $row = $this->denormalizeData($data);

        $this->emi->persist($row);
        $this->emi->flush();

        return $row;
    }

    public function createFromArray(array $data) {
        $row = [];

        foreach($data as $el) {
            $tmpRow = $this->denormalizeData($el);
            $this->emi->persist($tmpRow);

            $row[] = $tmpRow;
        }
        
        $this->emi->flush();
        return $row;
    }

    public function denormalizeData(array $data) {
        return $this->denormalizer->denormalize($data, $this->getClassName());
    }
}