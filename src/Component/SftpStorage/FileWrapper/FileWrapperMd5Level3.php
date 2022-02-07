<?php


namespace App\Component\SftpStorage\FileWrapper;


use InvalidArgumentException;
use SplFileInfo;

class FileWrapperMd5Level3 implements FileWrapperInterface
{
    protected SplFileInfo $fileInfo;
    protected string $hash;
    protected array $dirs;
    protected string $extension;
    protected string $filenameToSave;
    protected string $relativePath;

    public function __construct(SplFileInfo $fileInfo, ?string $extension = null)
    {
        $this->fileInfo = $fileInfo;
        $path = $this->fileInfo->getPathname();
        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('file not found: %s', $path));
        }
        $this->hash = md5_file($path);
        $this->dirs = array_slice(str_split($this->hash, 3), 0, 3);
        if (is_null($extension)) {
            $this->extension = trim($fileInfo->getExtension());
        } else {
            $this->extension = trim($extension);
        }
        if ($this->extension) {
            $this->filenameToSave = join('.', [$this->hash, $this->extension]);
        } else {
            $this->filenameToSave = $this->hash;
        }
        $relative_path = $this->dirs;
        array_push($relative_path, $this->filenameToSave);
        $this->relativePath = '/' . join('/', $relative_path);
    }

    public function getFileInfo(): SplFileInfo
    {
        return $this->fileInfo;
    }

    public function getFilenameToSave(): string
    {
        return $this->filenameToSave;
    }

    public function getDirsHierarchyToSave(): array
    {
        return $this->dirs;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getRelativePath(): string
    {
        return $this->relativePath;
    }
}