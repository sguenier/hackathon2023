<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'id_job', targetEntity: User::class)]
    private Collection $list_users;

    #[ORM\Column]
    private ?bool $intern = null;

    public function __construct()
    {
        $this->list_users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getListUsers(): Collection
    {
        return $this->list_users;
    }

    public function addListUser(User $listUser): self
    {
        if (!$this->list_users->contains($listUser)) {
            $this->list_users->add($listUser);
            $listUser->setIdJob($this);
        }

        return $this;
    }

    public function removeListUser(User $listUser): self
    {
        if ($this->list_users->removeElement($listUser)) {
            // set the owning side to null (unless already changed)
            if ($listUser->getIdJob() === $this) {
                $listUser->setIdJob(null);
            }
        }

        return $this;
    }

    public function isIntern(): ?bool
    {
        return $this->intern;
    }

    public function setIntern(bool $intern): self
    {
        $this->intern = $intern;

        return $this;
    }
}
