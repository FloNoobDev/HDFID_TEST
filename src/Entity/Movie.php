<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $adult = null;

    #[ORM\Column]
    private ?int $tmdbId = null;

    #[ORM\Column(length: 100)]
    private ?string $original_language = null;

    #[ORM\Column(length: 255)]
    private ?string $original_title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $overview = null;

    #[ORM\Column(length: 255)]
    private ?string $poster_path = null;

    #[ORM\Column(length: 12)]
    private ?string $release_date = null;

    #[ORM\ManyToOne(inversedBy: 'results')]
    private ?Movies $movies = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAdult(): ?bool
    {
        return $this->adult;
    }

    public function setAdult(bool $adult): static
    {
        $this->adult = $adult;

        return $this;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(int $tmdbId): static
    {
        $this->tmdbId = $tmdbId;

        return $this;
    }

    public function getOriginalLanguage(): ?string
    {
        return $this->original_language;
    }

    public function setOriginalLanguage(string $original_language): static
    {
        $this->original_language = $original_language;

        return $this;
    }

    public function getOriginalTitle(): ?string
    {
        return $this->original_title;
    }

    public function setOriginalTitle(string $original_title): static
    {
        $this->original_title = $original_title;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): static
    {
        $this->overview = $overview;

        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->poster_path;
    }

    public function setPosterPath(string $poster_path): static
    {
        $this->poster_path = $poster_path;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->release_date;
    }

    public function setReleaseDate(string $release_date): static
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getMovies(): ?Movies
    {
        return $this->movies;
    }

    public function setMovies(?Movies $movies): static
    {
        $this->movies = $movies;

        return $this;
    }


}
