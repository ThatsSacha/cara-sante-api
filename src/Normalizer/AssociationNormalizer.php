<?php

namespace App\Normalizer;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorResolverInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class AssociationNormalizer
 *
 * @package App\Normalizer
 */
class AssociationNormalizer extends ObjectNormalizer
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * EntityNormalizer constructor.
     *
     * @param EntityManagerInterface                   $entityManager
     * @param ClassMetadataFactoryInterface|null       $classMetadataFactory
     * @param NameConverterInterface|null              $nameConverter
     * @param PropertyAccessorInterface|null           $propertyAccessor
     * @param PropertyTypeExtractorInterface|null      $propertyTypeExtractor
     * @param ClassDiscriminatorResolverInterface|null $classDiscriminatorResolver
     * @param callable|null                            $objectClassResolver
     * @param array                                    $defaultContext
     */
    public function __construct(EntityManagerInterface $entityManager, ClassMetadataFactoryInterface $classMetadataFactory = null, NameConverterInterface $nameConverter = null, PropertyAccessorInterface $propertyAccessor = null, PropertyTypeExtractorInterface $propertyTypeExtractor = null, ClassDiscriminatorResolverInterface $classDiscriminatorResolver = null, callable $objectClassResolver = null, array $defaultContext = [])
    {
        parent::__construct($classMetadataFactory, $nameConverter, $propertyAccessor, $propertyTypeExtractor, $classDiscriminatorResolver, $objectClassResolver, $defaultContext);
        $this->entityManager = $entityManager;
    }

    /**
     * @param      $data
     * @param      $type
     * @param null|string $format
     *
     * @return bool
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        $oneToMany = strpos($type, 'App\\Entity\\') === 0 && (is_string($data) || is_numeric($data));
        $manyToOne = strpos($type, 'App\\Entity\\') === 0 && strpos($type, '[]') !== false && is_array($data);

        return $oneToMany || $manyToOne;
    }

    /**
     * @param       $data
     * @param       $class
     * @param null  $format
     * @param array $context
     *
     * @return object|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function denormalize($data, $class, string $format = null, array $context = [])
    {
        if (is_array($data)) {
            return array_map(function($id) use ($class) {
                return $this->entityManager->find(str_replace('[]', '', $class), $id);
            }, $data);
        } else {
            return $this->entityManager->find($class, $data);
        }
    }
}
