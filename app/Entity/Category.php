<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[Entity, Table("categories")]
class Category
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(name: "created_at")]
    private \DateTime $createdAt;

    #[ORM\Column(name: "updated_at")]
    private \DateTime $updatedAt;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    private User $user;

    #[ORM\OneToMany(mappedBy: "category", targetEntity: "Transaction")]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Catergory
    {
        $user->addCategory($this);

        $this->user = $user;

        return $this;
    }

    public function getTransactions(): ArrayCollection|Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): Catergory
    {
        $this->transactions->add($transaction);

        return $this;
    }

}
