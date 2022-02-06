<?php

namespace App\Dto\SiteImportDataCommand;

use DateTime;
use RuntimeException;
use Throwable;

class DataItem
{
    private int $id;
    private string $name;
    private ?DateTime $birthDate;
    private ?int $birthYear;
    private ?DateTime $deathDate;
    private ?int $deathYear;
    private ?int $age;
    private string $burialTypeName;
    private string $sectionName;
    private string $alleyName;
    private string $cemeteryName;#
    private string $latitude;#
    private string $longitude;#
    private string $firstPhotoPath;#
    private string $secondPhotoPath;#

    public static function createFromArray(array $data): self
    {
        try {
            $obj = new self;
            $obj->setId(self::parseId($data['id']))
                ->setName($data['name'])
                ->setBirthDate(self::parseDate($data['birthDate']))
                ->setBirthYear(self::parseYear($data['birthYear']))
                ->setDeathDate(self::parseDate($data['deathDate']))
                ->setDeathYear(self::parseYear($data['deathYear']))
                ->setAge(self::parseAge($data['age']))
                ->setBurialTypeName($data['burialTypeName'])
                ->setSectionName($data['sectionName'])
                ->setAlleyName($data['alleyName'])
                ->setCemeteryName($data['cemeteryName'])
                ->setLatitude(self::parseCoordinate($data['latitude']))
                ->setLongitude(self::parseCoordinate($data['longitude']))
                ->setFirstPhotoPath($data['firstPhotoPath'])
                ->setSecondPhotoPath($data['secondPhotoPath']);
        } catch (Throwable $exception) {
            throw new RuntimeException(sprintf('unable to create data item from array: %s', $exception->getMessage()), $exception->getCode(), $exception);
        }
        return $obj;
    }

    private static function parseId($assumed): int
    {
        if (preg_match('/([\\d]+)/', $assumed, $m)) {
            return intval($m[1]);
        }
        throw new RuntimeException(sprintf('unable to parse id: %s', $assumed));
    }

    private static function parseYear($assumed): ?int
    {
        if (preg_match('/[\\d]{4}/', $assumed, $m)) {
            return intval($m[0]);
        }
        return null;
    }

    private static function parseCoordinate(mixed $assumed): float
    {
        try {
            $assumed = trim($assumed);
        } catch (Throwable $exception) {
            return 0;
        }
        if (preg_match('/^[\\d]{1,15}\.[\\d]{1,12}$/', $assumed, $m)) {
            return floatval($m[0]);
        }
        if (preg_match('/^[\\d]+$/', $assumed, $m)) {
            return floatval($m[0]);
        }
        return 0;
    }

    private static function parseAge($assumed): ?int
    {
        if (preg_match('/[\\d]{1,3}/', $assumed, $m)) {
            return intval($m[0]);
        }
        return null;
    }

    private static function parseDate($assumed): ?DateTime
    {
        if (preg_match('/([\\d]{2}).*?([\\d]{2}).*?([\\d]{4})/', trim($assumed), $m)) {
            $timestamp = strtotime(sprintf('%04d-%02d-%02d 00:00:00', $m[3], $m[2], $m[1]));
            if (false === $timestamp) {
                return null;
            }
            $d = new DateTime;
            $d->setTimestamp($timestamp);
            return $d;
        }
        return null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): DataItem
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): DataItem
    {
        $this->name = $name;
        return $this;
    }

    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function getBirthDateMysql(): ?string
    {
        if ($this->birthDate instanceof DateTime) {
            return date('Y-m-d H:i:s', $this->birthDate->getTimestamp());
        }
        return null;
    }

    public function setBirthDate(?DateTime $birthDate): DataItem
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getDeathDate(): ?DateTime
    {
        return $this->deathDate;
    }

    public function getDeathDateMysql(): ?string
    {
        if ($this->deathDate instanceof DateTime) {
            return date('Y-m-d H:i:s', $this->deathDate->getTimestamp());
        }
        return null;
    }

    public function setDeathDate(?DateTime $deathDate): DataItem
    {
        $this->deathDate = $deathDate;
        return $this;
    }

    public function getBirthYear(): ?int
    {
        return $this->birthYear;
    }

    public function setBirthYear(?int $birthYear): DataItem
    {
        $this->birthYear = $birthYear;
        return $this;
    }

    public function getDeathYear(): ?int
    {
        return $this->deathYear;
    }

    public function setDeathYear(?int $deathYear): DataItem
    {
        $this->deathYear = $deathYear;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): DataItem
    {
        $this->age = $age;
        return $this;
    }

    public function getBurialTypeName(): string
    {
        return $this->burialTypeName;
    }

    public function setBurialTypeName(string $burialTypeName): DataItem
    {
        $this->burialTypeName = $burialTypeName;
        return $this;
    }

    public function getSectionName(): string
    {
        return $this->sectionName;
    }

    public function setSectionName(string $sectionName): DataItem
    {
        $this->sectionName = $sectionName;
        return $this;
    }

    public function getAlleyName(): string
    {
        return $this->alleyName;
    }

    public function setAlleyName(string $alleyName): DataItem
    {
        $this->alleyName = $alleyName;
        return $this;
    }

    public function getCemeteryName(): string
    {
        return $this->cemeteryName;
    }

    public function setCemeteryName(string $cemeteryName): DataItem
    {
        $this->cemeteryName = $cemeteryName;
        return $this;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): DataItem
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): DataItem
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getFirstPhotoPath(): string
    {
        return $this->firstPhotoPath;
    }

    public function setFirstPhotoPath(string $firstPhotoPath): DataItem
    {
        $this->firstPhotoPath = $firstPhotoPath;
        return $this;
    }

    public function getSecondPhotoPath(): string
    {
        return $this->secondPhotoPath;
    }

    public function setSecondPhotoPath(string $secondPhotoPath): DataItem
    {
        $this->secondPhotoPath = $secondPhotoPath;
        return $this;
    }
}
