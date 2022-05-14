<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $designation;

    #[ORM\OneToMany(mappedBy: 'appartient', targetEntity: Etudiant::class)]
    private $Section;

    public function __construct()
    {
        $this->Section = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->Section;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->Section->contains($etudiant)) {
            $this->Section[] = $etudiant;
            $etudiant->setAppartient($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->Section->removeElement($etudiant)) {
            if ($etudiant->getAppartient() === $this) {
                $etudiant->setAppartient(null);
            }
        }

        return $this;
    }
    public function getSection(): Collection
    {
        return $this->Section;
    }

    public function addSection(Etudiant $section): self
    {
        if (!$this->Section->contains($section)) {
            $this->Section[] = $section;
            $section->setAppartient($this);
        }

        return $this;
    }

    public function removeSection(Etudiant $section): self
    {
        if ($this->Section->removeElement($section)) {
            if ($section->getAppartient() === $this) {
                $section->setAppartient(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->designation;
    }
}
