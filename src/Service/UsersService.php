<?php

namespace App\Service;

use Exception;
use App\Entity\Users;
use IntlDateFormatter;
use App\Entity\UserExport;
use App\Entity\DetectionTest;
use App\Repository\UsersRepository;
use App\Repository\UserExportRepository;
use Doctrine\ORM\EntityManagerInterface;
use function Sodium\randombytes_uniform;
use Doctrine\ORM\Query\AST\Functions\ConcatFunction;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersService extends AbstractRestService {
    private $passwordHasher;
    private $repository;
    private $emi;
    private $mailerService;
    private $mailTemplateService;
    private $detectionTestService;

    public function __construct(
        UsersRepository $repository,
        EntityManagerInterface $emi,
        DenormalizerInterface $denormalizer,
        UserPasswordHasherInterface $passwordHasher,
        NormalizerInterface $normalizer,
        MailerService $mailerService,
        MailTemplateService $mailTemplateService,
        DetectionTestService $detectionTestService
    ) {
        parent::__construct($repository, $emi, $denormalizer, $normalizer);

        $this->passwordHasher = $passwordHasher;
        $this->repository = $repository;
        $this->emi = $emi;
        $this->mailerService = $mailerService;
        $this->mailTemplateService = $mailTemplateService;
        $this->detectionTestService = $detectionTestService;
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
                $this->verifyPhoneNumber($data['phone']);

                $data['firstName'] = ucfirst(strtolower($data['firstName']));
                $data['lastName'] = strtoupper($data['lastName']);
                $data['password'] = md5(random_bytes(10));
                $data['password'] = $this->passwordHasher->hashPassword(new Users, $data['password']);
                $data['createdAt'] = date_format(date_create('now'),  'Y-m-d H:i:s');
                $data['createdBy'] = $user->getId();
                $data['token'] = $this->generateToken();
                $data['ref'] = hash('crc32', time()) . '-' . uniqid() . '-' . uniqid();

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

    public function resendMailNewUser(string $ref) {
        try {
            $user = $this->repository->findOneBy(array(
                'ref' => $ref
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
            $user->getFirstName() . ', votre compte Liora a été créé !',
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
     * @param string $phone
     * 
     * @throws Exception
     */
    public function verifyPhoneNumber(string $phone) {
        if (!is_numeric($phone) || !preg_match('/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/', $phone)) {
            $this->throwError(["Le format du numéro de téléphone est erroné"]);
        }
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
        try {
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
                $this->verifyPhoneNumber($data['phone']);
                $me->setPhone($data['phone']);
            }
    
            $this->emi->persist($me);
            $this->emi->flush();

            return array(
                'status' => 200,
                'user' => $me
            );
        } catch (Exception $e) {
            return array(
                'status' => $e->getCode() ? $e->getCode() : 400,
                'message' => $e->getMessage()
            );
        }
    }

    /**
     * @param Users $user
     * 
     * @return array
     */
    public function findAllExceptCurrent(Users $currentUser): array {
       return $this->repository->findAllWithDetectionTestCount($currentUser);
    }

    public function findAllLight(Users $currentUser): array {
        $users = $this->repository->findAll();
        $ret = [];

        foreach($users as $user) {
            if ($user->getId() !== $currentUser->getId()) {
                $ret[] = $user->jsonSerializeUltraLight();
            }
        }

        return $ret;
    }

    /**
     * @param int $id
     * @param Users $user
     * 
     * @return array
     */
    public function findByExceptCurrent(string $ref, Users $currentUser): array {
        $users = $this->repository->findBy(array('ref' => $ref));
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
     * @param Users $user
     * @param string $type
     * 
     * @return array
     */
    public function getStats(Users $user, string $type): array {
        return $this->detectionTestService->getStats($user, $type);
    }

    public function desactivate(string $ref, Users $user) {
        try {
            if ($this->isAdmin($user)) {
                $userToDesactivate = $this->getByRef($ref);

                if ($userToDesactivate !== null) {
                    $userSerialized = $user->jsonSerialize();
                    $detectionTestNumber = count($userSerialized['detectionTests']);
                    
                    if ($detectionTestNumber > 0) {
                        $sentence = 'Vous avez largement contribué(e) à notre développement et nous vous en remerciont !<br/><strong>Vous avez au total saisit '. $detectionTestNumber .' tests Covid !</strong>';
                    } else {
                        $sentence = 'Vous avez largement contribué(e) à notre développement et nous vous en remerciont !';
                    }

                    $this->mailerService->sendMail(
                        $userToDesactivate->getEmail(),
                        'C\'est l\'heure de se dire au revoir...',
                        $this->mailTemplateService->getDesactivateAccount($userToDesactivate->getFirstName(), $sentence)
                    );

                    $this->anonymiseUser($userToDesactivate, $user);

                    return array(
                        'status' => 200
                    );
                } else {
                    throw new Exception('Cet utilisateur est introuvable.');
                }
            } else {
                throw new Exception('Vous devez être administrateur pour pouvoir désactiver un compte.');
            }
        } catch (Exception $e) {
            return array(
                'status' => $e->getCode() ? $e->getCode() : 400,
                'message' => $e->getMessage()
            );
        }
    }

    /**
     * @param Users $userToDesactivate
     * @param Users $userDesactivating
     * 
     * @return void
     */
    public function anonymiseUser(Users $userToDesactivate, Users $userDesactivating): void {
        $userToDesactivate->setEmail(null);
        $userToDesactivate->setPhone(null);
        $userToDesactivate->setDesactivatedAt(date_create());
        $userToDesactivate->setDesactivatedBy($userDesactivating);
        $userToDesactivate->setIsDesactivated(true);

        $this->emi->persist($userToDesactivate);
        $this->emi->flush();
    }

    public function setLastLogin(Users $user): void {
        $user->setLastLogin(date_create());
        $this->emi->persist($user);
        $this->emi->flush();
    }

    /**
     * @param array $errors
     * 
     * @throws Exception
     */
    public function throwError(array $errors) {
        if (count($errors) > 0) {
            $error = implode(', ', $errors);
            throw new Exception($error, 400);
        }
    }

    public function calculateEarning(Users $user) {
        $startDate = date_create()->format('Y-m-01');
        // Get the last day of the month
        $endDate = date('Y-m-t', strtotime($startDate));
        $frenchMonth = IntlDateFormatter::formatObject(date_create($startDate), 'MMMM', 'fr');

        $earning = 0;
        
        // get UserExportRepo
        $userExportRepo = $this->emi->getRepository(UserExport::class);
        $detectionTests = $userExportRepo->exportDataFrom($user->getId(), $startDate, $endDate);

        foreach($detectionTests as $detectionTest) {
            $isInvoicedOnAmeliPro = $detectionTest['is_invoiced_on_amelipro'];
            $alreadyInvoicedBy = $detectionTest['already_invoiced_by_first_name'];

            if (!$isInvoicedOnAmeliPro && $alreadyInvoicedBy === null) {
                $earning += 3;
            }
        }

        return array(
            'status' => 200,
            'earning' => $earning,
            'month' => $frenchMonth
        );

    }

    public function getEarningChart(Users $user): array {
        $detectionTests = $user->getDetectionTests();
        $detectionTestRepo = $this->emi->getRepository(DetectionTest::class);

        $detectionTests = $detectionTestRepo->findBy(array(
            'user' => $user->getId()
        ), array(
            'filledAt' => 'ASC'
        ));

        $dataset = $this->calculateEarningPerDay($detectionTests);
            
        return array(
            'status' => 200,
            'labels' => array_values($dataset['labels']),
            'data' => array_values($dataset['data'])
        );
    }

    private function calculateEarningPerDay(array $detectionTests): array {
        $tmpEarningByDay = [];
        $tmpLabelDay = [];

        foreach($detectionTests as $detectionTest) {
            $filledAt = $detectionTest->getFilledAt();
            $isInvoicedOnAmeliPro = $detectionTest->getIsInvoicedOnAmelipro();
            $alreadyInvoicedBy = $detectionTest->getAlreadyInvoicedBy()?->getFirstName();
            $earning = 0;

            if (!$isInvoicedOnAmeliPro && $alreadyInvoicedBy === null) {
                $key = strtotime($filledAt->format('Y-m-d'));
                $label = IntlDateFormatter::formatObject($filledAt, 'dd MMMM', 'fr');

                if (!array_key_exists($key, $tmpEarningByDay)) {
                    $tmpEarningByDay[$key] = 0;
                }

                $earning += $tmpEarningByDay[$key] + 3;
                $tmpEarningByDay[$key] = $earning;
                $tmpLabelDay[$key] = $label;
            }
        }

        return array(
            'labels' => $tmpLabelDay,
            'data' => $tmpEarningByDay
        );
    }
}