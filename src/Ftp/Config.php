<?php /** @noinspection PhpPropertyOnlyWrittenInspection */ namespace App\Ftp;

use Throwable;

class Config
{
    private string $name;
    private string $host;
    private int $port;
    private int $timeout;
    private string $username;
    private string $password;
    private string $path;
    private bool $pasv;

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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function isPasv(): bool
    {
        return $this->pasv;
    }

    public function __construct(FtpManager $m, string $name) {
        try {
            $data = ($m->getConfiguration())[$name];
            foreach ($data as $k => $v) {
                $this->{$k} = $v;
            }
        } catch (Throwable $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
        $this->name = $name;
    }
}
