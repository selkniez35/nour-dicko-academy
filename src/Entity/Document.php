<?php

namespace App\Entity;

use App\Enum\DocumentTypeEnum;
use App\Repository\DocumentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membership $membership = null;

    #[ORM\Column(enumType: DocumentTypeEnum::class)]
    private DocumentTypeEnum $type;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filename = null;

    private ?UploadedFile $file = null;

    #[ORM\Column]
    private DateTimeImmutable $uploadedAt;

    public function __construct()
    {
        $this->uploadedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembership(): ?Membership
    {
        return $this->membership;
    }

    public function setMembership(Membership $membership): self
    {
        $this->membership = $membership;
        return $this;
    }

    public function getType(): DocumentTypeEnum
    {
        return $this->type;
    }

    public function setType(DocumentTypeEnum $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;
        return $this;
    }

    public function getUploadedAt(): DateTimeImmutable
    {
        return $this->uploadedAt;
    }
}