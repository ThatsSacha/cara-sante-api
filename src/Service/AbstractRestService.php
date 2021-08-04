<?php

namespace App\Service;
use Normalizer;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class AbstractRestService {
    private $repository;
    private $className;
    private $denormalize;
    private $emi;

    public function __construct(ServiceEntityRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer)
    {
        $this->repository = $repository;
        $this->className = $repository->getClassName();
        $this->denormalize = $denormalizer;
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
        //dd($this->emi->getRepository($this->className));
        $this->emi->persist($row);
        $this->emi->flush();

        return $row;
    }

    public function denormalizeData(array $data) {
        return $this->denormalize->denormalize($data, $this->getClassName());
    }
}