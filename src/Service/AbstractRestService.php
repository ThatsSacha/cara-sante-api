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
    private $className;
    private $denormalize;
    private $emi;

    public function __construct(ServiceEntityRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer)
    {
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

    public function create(array $data) {
        $row = $this->denormalize->denormalize($data, $this->getClassName());
        
        $this->emi->persist($row);
        $this->emi->flush();

        return $row;
    }
}