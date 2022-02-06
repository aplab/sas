<?php

namespace App\Entity;

use App\Component\DataTableRepresentation\CellType\CellTypeEditId;
use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypePassword;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Traits\EntityFields\ActivationKey;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\Avatar;
use App\Traits\EntityFields\Birthdate;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Deleted;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\SecretKey;
use App\Traits\EntityFields\Signature;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\UniqueConstraint;
use InvalidArgumentException;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[UniqueEntity(fields: ['email'], message: "It looks like your already have an account!")]
#[Module(title: 'User', description: 'User entity', tab_order: [
    'General' => 1000,
    'Image' => 3000,
    'Contact' => 4000,
    'SEO' => 5000,
    'SEO2' => 5000,
    'Security' => 10000400,
    'Additional' => 10000418,
])]
#[Entity(repositoryClass: 'App\Repository\UserRepository')]
#[UniqueConstraint(name:"activation_key", columns:["activation_key"])]
#[UniqueConstraint(name:"secret_key", columns:["secret_key"])]
class User implements UserInterface
{
    use Name;
    use Birthdate;
    use CreatedAtLastModified;
    use Signature;
    use Deleted;
    use ActivationKey;
    use Avatar;
    use Active;
    use SecretKey;

    public function __construct()
    {
        $this->createdAt = new DateTime;
        $this->newActivationKey();
        $this->newSecretKey();
    }

    const MIN_PASSWORD_LENGTH = 8;

    private static UserPasswordEncoderInterface $passwordEncoder;

    public static function setPasswordEncoder(UserPasswordEncoderInterface $password_encoder)
    {
        static::$passwordEncoder = $password_encoder;
    }

    private static ValidatorInterface $validator;

    public static function setValidator(ValidatorInterface $validator)
    {
        static::$validator = $validator;
    }

    #[Property(title: 'ID', readonly: true)]
    #[Cell(type: CellTypeEditId::class, order: 1000, width: 80)]
    #[Widget(type: FieldTypeLabel::class, order: 1000, tab: TabDef::ADDITIONAL)]
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'bigint', options: ['unsigned' => true])]
    private $id;

    /**
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    #[Property(title: 'Email')]
    #[Cell(type: CellTypeLabel::class, order: 2000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[Column(type: 'json')]
    private $roles = [];

    /**
     * @var string The hashed password
     * @Assert\NotBlank(message="Password should be not blank")
     */
    #[Property(title: 'Password')]
    #[Widget(type: FieldTypePassword::class, order: 2000, tab: TabDef::SECURITY)]
    #[Column(type: 'string')]
    private string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $l = mb_strlen($email);
        if (!$l) {
            throw new InvalidArgumentException('username cannot be empty');
        }
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): static
    {
        $l = mb_strlen($password);
        if (!$l) {
            return $this;
        }
        if ($l < static::MIN_PASSWORD_LENGTH) {
            throw new InvalidArgumentException('password too short, 8 characters needed');
        }
        $constraint = new Assert\NotCompromisedPassword();
        $validator = static::$validator;
        $errors = $validator->validate($password, $constraint);
        if (sizeof($errors)) {
            throw new InvalidArgumentException((string)$errors);
        }
        $encoded = static::$passwordEncoder->encodePassword(
            $this, $password);
        $this->password = $encoded;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
