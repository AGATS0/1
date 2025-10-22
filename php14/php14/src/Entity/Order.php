<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    public function __construct()
    {
        $this->dish = new ArrayCollection();
    }

    /**
     * @var Collection<int, Dish>
     */
    #[Assert\Count(
        min: 1,
        minMessage: 'Нужен хотя бы один заказ',
    )]
    #[ORM\ManyToMany(targetEntity: Dish::class)]
    private Collection $dish;

    #[ORM\ManyToOne]
    private ?Client $client = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Dish>
     */
    public function getDish(): Collection
    {
        return $this->dish;
    }

    public function addDish(Dish $dish): static
    {
        if (!$this->dish->contains($dish)) {
            $this->dish->add($dish);
        }

        return $this;
    }

    public function removeDish(Dish $dish): static
    {
        $this->dish->removeElement($dish);

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
