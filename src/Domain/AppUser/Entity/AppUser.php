<?php

namespace App\Domain\AppUser\Entity;

use App\Domain\AppUser\UserRol;
use App\Infrastructure\AppUser\Persistence\AppUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AppUserRepository::class)]
class AppUser
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    public function __construct(
        #[ORM\Column(length: 255, unique: true)]
        private string $email,

        #[ORM\Column(length: 255)]
        private string $password,

        #[ORM\Column(length: 255)]
        private string $name,

        #[ORM\Column(length: 255)]
        private string $surname,
        /**
         * @var array<UserRol>
         */
        #[ORM\Column(type: Types::JSON)]
        private array $roles = [],

        #[ORM\Column]
        private ?\DateTimeImmutable $createdAt = null,

        #[ORM\Column(nullable: true)]
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return UserRol[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
