<?php

namespace App\Ftp;

class FileMetadata
{
    private int $timestamp, $expectedRecordsNumber;
    private string $path, $date;

    public function __construct(string $path, int $timestamp, int $expected_records_number)
    {
        $this->path = $path;
        $this->timestamp = $timestamp;
        $this->expectedRecordsNumber = $expected_records_number;
        $this->date = date('Y-m-d H:i:s', $this->timestamp);
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getExpectedRecordsNumber(): int
    {
        return $this->expectedRecordsNumber;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
