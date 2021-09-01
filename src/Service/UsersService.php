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
                $data['token'] = $this->generateToken();

                $user = $this->create($data);
                $this->mailNewUser($user, false, $data);
                
                return $user->jsonSerialize();
            }

            throw new Exception("Vous n'avez pas les droits pour créer un utilisateur");
        } catch (Exception $e) {
            return array(
                'status' => $e->getCode() ? $e->getCode() : 400,
                'message' => $e->getMessage()
            );
        }
    }

    public function resendMailNewUser(int $id) {
        try {
            $user = $this->repository->findOneBy(array(
                'id' => $id
            ));
    
            if ($user !== null) {
                if ($user->getIsFirstConnection()) {
                    $this->mailNewUser($user, true);

                    return array(
                        'status' => 200
                    );
                }

                throw new Exception('Vous ne pouvez pas envoyer de mail de confirmation à cet utilisateur');
            }

            throw new Exception('Une erreur s\'est produite');
        } catch (Exception $e) {
            return array(
                'status' => $e->getCode() ? $e->getCode() : 400,
                'message' => $e->getMessage()
            );
        }
    }

    /**
     * @param Users $user
     * @param bool $generateAndUpdateToken
     * @param array $data
     * 
     * @return void
     * @throws Exception
     */
    public function mailNewUser(Users $user, bool $generateAndUpdateToken = false, array $data = []): void {
        if ($generateAndUpdateToken) {
            $token = $this->generateToken();
            $user->setToken($token);
            $data['firstName'] = $user->getFirstName();
            $data['token'] = $user->getToken();

            $this->emi->persist($user);
            $this->emi->flush();
        }

        $this->mailerService->sendMail(
            $user->getEmail(),
            $user->getFirstName() . ', votre compte Cara Santé a été créé !',
            $this->mailTemplateService->getUserCreated($data)
        );
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

    public function verifyTokenSetPassword(string $token): array {
        $user = $this->getUserByToken($token);

        if ($user !== null) {
            $user->setToken($this->generateToken());
            $this->emi->persist($user);
            $this->emi->flush();

            return array(
                'code' => 200,
                'token' => $user->getToken()
            );
        }

        return array(
            'code' => 400,
            'message' => 'Cette URL est erronée. Veuillez refaire une demande'
        );
    }

    /**
     * @param string $token
     * 
     * @return Users|null
     */
    public function getUserByToken(string $token): Users|null {
        return $this->repository->findOneBy(array(
            'token' => $token
        ));
    }

    public function generateToken(): string {
        return strtoupper(hash('sha256', random_bytes(30)));
    }

    public function setPassword(array $data, string $token) {
        try {
            $user = $this->getUserByToken($token);
            
            if ($user !== null) {
                $mandatoryFields = ['password', 'confirmPassword'];
                $this->verifyMandatoryFields($mandatoryFields, $data);
                $this->verifyBothPassword($data['password'], $data['confirmPassword']);
                $this->verifyPassword($data['password']);

                $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
                $user->setPassword($hashedPassword);
                $user->setToken(null);
                $user->setIsFirstConnection(false);
                
                $this->emi->persist($user);
                $this->emi->flush();

                return array(
                    'status' => 200
                );
            }

            throw new Exception('Une erreur s\'est produite');
        } catch (Exception $e) {
            return array(
                'status' => $e->getCode() ? $e->getCode() : 400,
                'message' => $e->getMessage()
            );
        }
    }

    /**
     * @param string $password
     * @param string $confirmPassword
     * 
     * @return void
     * @throws Exception
     */
    public function verifyBothPassword(string $password, string $confirmPassword): void {
        if ($password !== $confirmPassword) {
            throw new Exception('Les deux mots de passe ne correspondent pas');
        }
    }

    /**
     * @param string $password
     * 
     * @throws Exception
     */
    public function verifyPassword(string $password) {
        $verifyPasswordLength = $this->verifyPasswordLength($password);
        $verifyPasswordNumerics = $this->verifyPasswordNumerics($password);
        $verifyPasswordSpecialCharacters = $this->verifyPasswordSpecialCharacters($password);

        if ($verifyPasswordLength || $verifyPasswordNumerics || $verifyPasswordSpecialCharacters) {
            $this->throwError([$verifyPasswordLength, $verifyPasswordNumerics, $verifyPasswordSpecialCharacters]);
        }
    }

    /**
     * @param string $password
     * 
     * @return string|null
     */
    public function verifyPasswordSpecialCharacters(string $password): string|null {
        $specialCharacters = ['@', '&', '#', '(', ')', '!', '.', '?', ',', ';', '+', '$', '*', '^', '<', '>', '§', '°', '-', '_', '=', ':'];

        $numberOfSpecialCharacters = 0;

        for($i = 0; $i < strlen($password); $i++) {
            if (in_array($password[$i], $specialCharacters)) {
                $numberOfSpecialCharacters++;
            }
        }

        if ($numberOfSpecialCharacters < 1) {
            return 'Le mot de passe doit être composé au minimun de 1 caractère spécial';
        }

        return null;
    }

    /**
     * @param string $password
     * 
     * @return string|null
     */
    public function verifyPasswordNumerics(string $password): string|null {
        $numberOfNumerics = 0;

        for($i = 0; $i < strlen($password); $i++) {
            if (is_numeric($password[$i])) {
                $numberOfNumerics++;
            }
        }

        if ($numberOfNumerics < 2) {
            return 'Le mot de passe doit être composé au minimun de 2 chiffres';
        }

        return null;
    }

    /**
     * @param string $password
     * 
     * @return string|null
     */
    public function verifyPasswordLength(string $password): string|null {
        if (strlen($password) < 8) {
            return 'Le mot de passe doit être composé au minimun de 8 caractères';
        }

        return null;
    }

    public function resetPassword(array $data) {
        try {
            $mandatoryFields = ['email'];
            $this->verifyMandatoryFields($mandatoryFields, $data);
            $this->verifyMailFormat($data['email']);
    
            $user = $this->repository->findOneBy(array(
                'email' => $data['email']
            ));
            
            if ($user !== null) {
                $token = $this->generateToken();
                $user->setToken($token);
                $data['firstName'] = $user->getFirstName();
                $data['token'] = $token;
                $this->emi->persist($user);
                $this->emi->flush();
                
        
                $this->mailerService->sendMail(
                    $user->getEmail(),
                    $user->getFirstName() . ', rénitialisez votre mot de passe !',
                    $this->mailTemplateService->getForgotPassword($data)
                );
            } else {
                sleep(2);
            }

            return array(
                'status' => 200
            );
        } catch (Exception $e) {
            return array(
                'status' => $e->getCode() ? $e->getCode() : 400,
                'message' => $e->getMessage()
            );
        }
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