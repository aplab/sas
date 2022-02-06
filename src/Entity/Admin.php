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
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use InvalidArgumentException;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['username'], message: "It looks like your already have an account!")]
#[Module(title: 'Admin', description: 'Admin entity', tab_order: [
    'General' => 1000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: 'App\Repository\AdminRepository')]
class Admin implements UserInterface
{
    /**
     * @var int
     */
    const MIN_PASSWORD_LENGTH = 8;

    /**
     * @var UserPasswordEncoderInterface
     */
    private static $passwordEncoder;

    /**
     * @param UserPasswordEncoderInterface $password_encoder
     */
    public static function setPasswordEncoder(UserPasswordEncoderInterface $password_encoder)
    {
        static::$passwordEncoder = $password_encoder;
    }

    #[Property(title: 'ID', readonly: true)]
    #[Cell(type: CellTypeEditId::class, order: 1000, width: 80)]
    #[Widget(type: FieldTypeLabel::class, order: 1000, tab: TabDef::ADDITIONAL)]
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    #[Property(title: 'Name')]
    #[Cell(type: CellTypeLabel::class, order: 2000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[Column(type: 'json')]
    private $roles = [];

    #[Assert\NotBlank(message: 'Password should be not blank')]
    #[Property(title: 'Password')]
    #[Widget(type: FieldTypePassword::class, order: 2000, tab: 'General')]
    #[Column(type: 'string')]
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->username;
    }

    public function setUsername(string $username): static
    {
        $l = mb_strlen($username);
        if (!$l) {
            throw new InvalidArgumentException('username cannot be empty');
        }
        $this->username = $username;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_ADMIN';

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
