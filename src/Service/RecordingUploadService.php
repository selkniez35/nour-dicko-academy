<?php

namespace App\Service;

use App\Entity\CourseSession;
use App\Entity\Recording;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RecordingUploadService
{
    public function __construct(private readonly string $recordingsDirectory)
    {
    }

    public function store(CourseSession $session, UploadedFile $file, User $uploadedBy, ?string $title): Recording
    {
        if (!is_dir($this->recordingsDirectory)) {
            mkdir($this->recordingsDirectory, 0775, true);
        }

        $extension = $file->guessExtension() ?: $file->getClientOriginalExtension();
        $storedFilename = bin2hex(random_bytes(16)) . ($extension ? '.' . $extension : '');

        $mimeType = $file->getMimeType() ?? 'application/octet-stream';
        $originalFilename = $file->getClientOriginalName();
        $fileSize = (int) ($file->getSize() ?? 0);

        $file->move($this->recordingsDirectory, $storedFilename);

        $recording = new Recording();
        $recording->setCourseSession($session);
        $recording->setTitle($title);
        $recording->setFilename($storedFilename);
        $recording->setOriginalFilename($originalFilename);
        $recording->setMimeType($mimeType);
        $recording->setFileSize($fileSize);
        $recording->setUploadedBy($uploadedBy);

        return $recording;
    }

    public function delete(Recording $recording): void
    {
        $path = $this->getFilePath($recording);
        if (is_file($path)) {
            unlink($path);
        }
    }

    public function getFilePath(Recording $recording): string
    {
        return rtrim($this->recordingsDirectory, '/') . '/' . $recording->getFilename();
    }
}
