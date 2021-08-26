<?php

namespace App\Service;

use Exception;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\AST\Functions\ConcatFunction;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Sodium\randombytes_uniform;

date_default_timezone_set('Europe/Paris');

class UsersService extends AbstractRestService {
    private $passwordHasher;
    private $repository;
    private $emi;
    private $mailerService;
    private $mailTemplateService;

    public function __construct(UsersRepository $repository, EntityManagerInterface $emi, DenormalizerInterface $denormalizer, UserPasswordHasherInterface $passwordHasher, NormalizerInterface $normalizer, MailerService $mailerService, MailTemplateService $mailTemplateService) {
        parent::__construct($repository, $emi, $denormalizer, $normalizer);

        $this->passwordHasher = $passwordHasher;
        $this->repository = $repository;
        $this->emi = $emi;
        $this->mailerService = $mailerService;
        $this->mailTemplateService = $mailTemplateService;
    }

    /**
     * @param array $data
     * @param Users $user
     * 
     * @return array
     */
    public function new(array $data, Users $user): array {
        try {
            if ($this->isAdmin($user)) {
                $mandatory = ['email', 'phone', 'firstName', 'lastName'];
                $this->verifyMandatoryFields($mandatory, $data);
                $this->verifyMailFormat($data['email']);
                $this->verifyUniqueMail($data['email']);

                $data['firstName'] = ucfirst(strtolower($data['firstName']));
                $data['lastName'] = strtoupper($data['lastName']);
                $data['password'] = md5(random_bytes(10));
                $data['password'] = $this->passwordHasher->hashPassword(new Users, $data['password']);
                $data['createdAt'] = date_format(date_create('now'),  'Y-m-d H:i:s');
                $data['createdBy'] = $user->getId();

                $user = $this->create($data);
                $this->mailerService->sendMail(
                    $user->getEmail(),
                    $user->getFirstName() . ', votre compte Cara Santé a été créé !',
                    $this->mailTemplateService->getUserCreated($data)
                );
                
                return $user->jsonSerialize();
            }

            throw new Exception("Vous n'avez pas les droits pour créer un utilisateur");
        } catch (Exception $e) {
            return array(
                'status' => 400,
                'message' => $e->getMessage()
            );
        }
    }

    /**
     * @param Users $user
     * 
     * @return bool
     */
    public function isAdmin(Users $user): bool {
        if (in_array('ROLE_ADMIN', $user->getRoles()) || in_array('ROLE_SUPERADMIN', $user->getRoles())) {
            return true;
        }

        return false;
    }

    /**
     * @param string $mail
     * 
     * @throws Exception
     */
    public function verifyUniqueMail(string $mail) {
        $users = $this->repository->findBy(array(
            'email' => $mail
        ));

        if (count($users) > 0) {
            $this->throwError(["Cette adresse mail est déjà utilisée"]);
        }
    }

    /**
     * @param string $mail
     * 
     * @throws Exception
     */
    public function verifyMailFormat(string $mail) {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $this->throwError(["Le format de l'adresse mail est erroné"]);
        }
    }

    /**
     * @param array $mandatoryFields
     * @param array $data
     */
    public function verifyMandatoryFields(array $mandatoryFields, array $data): array {
        $error = array();

        foreach($mandatoryFields as $field) {
            if (!in_array($field, $mandatoryFields) || !isset($data[$field]) || empty($data[$field])) {
                $error[] = "$field est manquant ou vide";
            }
        }

        return count($error) > 0 ? $this->throwError($error) : [];
    }

    /**
     * @param string $mail
     * 
     * @return Users
     */
    public function getUserByMail(string $mail): Users {
        return $this->repository->findOneBy(array('email' => $mail));
    }

    public function updateMe(array $data, Users $user) {
        $me = $this->getUserByMail($user->getEmail());
        
        if (isset($data['firstName']) && !empty($data['firstName'])) {
            $me->setFirstName($data['firstName']);
        }
        if (isset($data['lastName']) && !empty($data['lastName'])) {
            $me->setLastName($data['lastName']);
        }
        if (isset($data['mail']) && !empty($data['mail'])) {
            $this->verifyMailFormat($data['mail']);
            $this->verifyUniqueMail($data['mail']);
            $me->setEmail($data['mail']);
        }
        if (isset($data['phone']) && !empty($data['phone'])) {
            $me->setPhone($data['phone']);
        }

        $this->emi->persist($me);
        $this->emi->flush();
    }

    /**
     * @param Users $user
     * 
     * @return array
     */
    public function findAllExceptCurrent(Users $currentUser): array {
        $users = $this->repository->findAll();
        $usersSerialized = [];

        foreach($users as $user) {
            if ($user->getEmail() !== $currentUser->getEmail()) {
                $usersSerialized[] = $user->jsonSerialize();
            }
        }

        return $usersSerialized;
    }

    /**
     * @param int $id
     * @param Users $user
     * 
     * @return array
     */
    public function findByExceptCurrent(int $id, Users $currentUser): array {
        $users = $this->repository->findBy(array('id' => $id));
        $usersSerialized = [];

        foreach($users as $user) {
            if ($user->getEmail() !== $currentUser->getEmail()) {
                $usersSerialized[] = $user->jsonSerialize();
            }
        }

        return $usersSerialized;
    }

    /**
     * @param array $errors
     * 
     * @throws Exception
     */
    public function throwError(array $errors) {
        if (count($errors) > 0) {
            $error = implode(', ', $errors);
            throw new Exception($error);
        }
    }
}