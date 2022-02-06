<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace App\Ftp;

use Aplab\Pst\Lib\Path;
use Generator;
use RuntimeException;
use Throwable;

class Connection
{
    private FtpManager $manager;
    private Config $config;
    private $connection;

    public function __construct(FtpManager $m, Config $c)
    {
        $this->manager = $m;
        $this->config = $c;
    }

    protected function connect()
    {
        $c = ftp_connect($this->config->getHost(), $this->config->getPort(), $this->config->getTimeout());
        if (false === $c) {
            throw new RuntimeException(sprintf('unable to connect ftp %s', $this->config->getName()));
        }
        $this->connection = $c;
    }

    protected function login(): bool
    {
        try {
            $l = ftp_login($this->connection, $this->config->getUsername(), $this->config->getPassword());
            if (false === $l) {
                throw new RuntimeException(sprintf('unable to login ftp %s', $this->config->getName()));
            }
        } catch (Throwable $exception) {
            throw new RuntimeException(sprintf('unable to login ftp %s', $this->config->getName()));
        }
        return true;
    }

    protected function home(): bool
    {
        try {
            $c = ftp_chdir($this->connection, '/');
            if (false === $c) {
                throw new RuntimeException(sprintf('unable to enter home dir %s', $this->config->getName()));
            }
        } catch (Throwable $exception) {
            throw new RuntimeException(sprintf('unable to change passive mode ftp %s', $this->config->getName()));
        }
        return true;
    }

    protected function pasv(): bool
    {
        try {
            $p = ftp_pasv($this->connection, $this->config->isPasv());
            if (false === $p) {
                throw new RuntimeException(sprintf('unable to change passive mode %s', $this->config->getName()));
            }
        } catch (Throwable $exception) {
            throw new RuntimeException(sprintf('unable to change passive mode ftp %s', $this->config->getName()));
        }
        return true;
    }

    private function ls(): array
    {
        if (!is_resource($this->connection)) {
            $this->connect();
            $this->login();
        }
        $this->home();
        $this->pasv();
        return ftp_mlsd($this->connection, $this->config->getPath());
    }

    public function getTargetFilesOrdered(): array
    {
        $ret = [];
        $all = $this->ls();
        $re = '/GISData_([\\d]{2})_([\\d]{2})_([\\d]{4})_([\\d]{2})_([\\d]{2})_Records_([\\d]+)\\.txt/iu';
        foreach ($all as $file) {
            if ('file' !== $file['type']) {
                continue;
            }
            $name = $file['name'];
            if (preg_match($re, $name, $m)) {
                $timestamp = strtotime(sprintf('%04d-%02d-%02d %02d:%02d:00', $m[3], $m[2], $m[1], $m[4], $m[5]));
                if (false === $timestamp) {
                    throw new RuntimeException('unable to calculate timestamp');
                }
                $expected_records_number = $m[6];
                $path = (new Path($this->config->getPath(), $name))->toString();
                $ret[] = new FileMetadata($path, $timestamp, $expected_records_number);
            }
        }
        usort($ret, function (FileMetadata $a, FileMetadata $b) {
            return $a->getTimestamp() <=> $b->getTimestamp();
        });
        return $ret;
    }

    /**
     * @param FileMetadata $f
     * @return resource
     * @noinspection PhpDocSignatureInspection
     */
    public function loadData(FileMetadata $f)
    {
        $tmp_handle = tmpfile();
        if (false === $tmp_handle) {
            throw new RuntimeException('unable to create tmp file');
        }
        $meta = stream_get_meta_data($tmp_handle);
        $tmp_path = $meta['uri'];
        $this->download($this->connection, $tmp_path, $f->getPath(), 0);
        return $tmp_handle;
    }

    protected function download($ftp, string $local_filename, string $remote_filename, int $offset = 0)
    {
        $ret = ftp_nb_get($ftp, $local_filename, $remote_filename, FTP_BINARY, $offset);
        while ($ret == FTP_MOREDATA) {
            clearstatcache(true, $local_filename);
            printf("downloading data %s\r", number_format(filesize($local_filename)));
            $ret = ftp_nb_continue($this->connection);
        }
        if ($ret != FTP_FINISHED) {
            throw new RuntimeException('unable to ftp get file');
        }
    }
}
