<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploadService
{
    public function __construct(
        private readonly string $uploadsDirectory,
        private readonly SluggerInterface $slugger
    ) {
    }

    public function upload(UploadedFile $file, string $folder = ''): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename)->lower();
        $filename = sprintf('%s-%s.%s', $safeFilename, uniqid('', true), $file->guessExtension() ?: 'bin');

        $relativeFolder = trim($folder, '/');
        $targetDirectory = $this->uploadsDirectory;

        if ($relativeFolder !== '') {
            $targetDirectory .= DIRECTORY_SEPARATOR . $relativeFolder;
        }

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0775, true);
        }

        $file->move($targetDirectory, $filename);

        return $relativeFolder !== '' ? $relativeFolder . '/' . $filename : $filename;
    }

    public function remove(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $absolutePath = $this->uploadsDirectory . DIRECTORY_SEPARATOR . ltrim($relativePath, '/');

        if (is_file($absolutePath)) {
            unlink($absolutePath);
        }
    }
}
