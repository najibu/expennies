<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity, ORM\Table(name: "transactions")]
class Transaction
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    #[ORM\Column(type: "datetime")]
    private \DateTime $date;

    #[ORM\Column(type: "decimal", precision: 13, scale: 3)]
    private float $amount;

    #[ORM\Column(name: "created_at")]
    private \DateTime $createdAt;

    #[ORM\Column(name: "updated_at")]
    private ?\DateTime $updatedAt;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private User $user;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private Category $category;

    #[ORM\OneToMany(targetEntity: Receipt::class, mappedBy: "transaction")]
    private Collection $receipts;

    public function __construct()
    {
        $this->receipts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Transaction
    {
        $this->description = $description;
        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): Transaction
    {
        $this->date = $date;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): Transaction
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): Transaction
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): Transaction
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Transaction
    {
        $user->addTransaction($this);

        $this->user = $user;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): Transaction
    {
        $category->addTransaction($this);

        $this->category = $category;
        return $this;
    }

    public function getReceipts(): Collection
    {
        return $this->receipts;
    }

    public function addReceipt(Receipt $receipt): Transaction
    {
        $this->receipts->add($receipt);
        
        return $this;
    }
}
