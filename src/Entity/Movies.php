<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $total_results = null;

    #[ORM\OneToMany(mappedBy: 'movies', targetEntity: Movie::class)]
    private Collection $results;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalResults(): ?int
    {
        return $this->total_results;
    }

    public function setTotalResults(int $total_results): static
    {
        $this->total_results = $total_results;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Movie $result): static
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
            $result->setMovies($this);
        }

        return $this;
    }

    public function removeResult(Movie $result): static
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getMovies() === $this) {
                $result->setMovies(null);
            }
        }

        return $this;
    }
}
