<?php


namespace App\Component\SftpStorage\FileWrapper;


use SplFileInfo;

interface FileWrapperInterface
{
    public function __construct(SplFileInfo $fileInfo);
    public function getFileInfo(): SplFileInfo;
    public function getFilenameToSave(): string;
    public function getDirsHierarchyToSave(): array;
    public function getHash(): string;
    public function getRelativePath(): string;
}