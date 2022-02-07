<?php


namespace App\Component\SftpStorage;


use InvalidArgumentException;

class Config
{
    private const DEFAULT_PORT = 22;

    public static function init(array $data): array
    {
        $instances = [];
        foreach ($data as $name => $config) {
            if (!is_array($config)) {
                throw new InvalidArgumentException('wrong configuration');
            }
            $instance = new self;
            $instance->name = $name;
            foreach ($config as $property => $value) {
                if ('client_to_server' === $property || 'server_to_client' === $property) {
                    if (!isset($instance->methods) || !is_array($instance->methods)) {
                        $instance->methods = [];
                    }
                    $instance->methods[$property] = $value;
                    continue;
                }
                $instance->{$property} = $value;
            }
            $instances[$instance->getName()] = $instance;
        }
        return $instances;
    }

    private string $name;
    private string $host;
    private int $port = self::DEFAULT_PORT;
    private ?array $methods = null;
    private ?array $callbacks = null;
    private string $connector;
    private string $fingerprint;
    private string $username;
    private string $publicKeyPath;
    private string $privateKeyPath;
    private string $dataDirectory;

    public function getName(): string
    {
        return $this->name;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getMethods(): ?array
    {
        return $this->methods;
    }

    public function getCallbacks(): ?array
    {
        return $this->callbacks;
    }

    public function getConnector(): string
    {
        return $this->connector;
    }

    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPublicKeyPath(): string
    {
        return $this->publicKeyPath;
    }

    public function getPrivateKeyPath(): string
    {
        return $this->privateKeyPath;
    }

    public function getDataDirectory(): string
    {
        return $this->dataDirectory;
    }
}