<?php

namespace App\Service;
use Normalizer;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use App\Normalizer\AssociationNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractRestService {
    private $repository;
    private $className;
    private $denormalizer;
    private $emi;

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

    public function denormalizeData(array $data) {
        return $this->denormalizer->denormalize($data, $this->getClassName());
    }
}