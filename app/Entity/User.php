<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contracts\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;

#[ORM\Entity, ORM\Table(name: "users")]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface
{
    #[ORM\Id, ORM\Column(options: ["unsigned" => true]), ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    private string $password;

    #[ORM\Column(name: "created_at")]
    private \DateTime $createdAt;

    #[ORM\Column(name: "updated_at")]
    private ?\DateTime $updatedAt;

    #[ORM\OneToMany(targetEntity: "Category", mappedBy: "user")]
    private $categories;

    #[ORM\OneToMany(targetEntity: "Transaction", mappedBy: "user")]
    private $transactions;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    #[ORM\PrePersist, ORM\PreUpdate]
    public function updateTimestamps(LifecycleEventArgs $args): void
    {
        if (! isset($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }

        $this->updatedAt = new \DateTime();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function addCategory(Category $category): User
    {
       $this->categories->add($category);

        return $this;
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): User
    {
       $this->transactions->add($transaction);

        return $this;
    }
}
