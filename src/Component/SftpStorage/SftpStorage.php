<?php


namespace App\Component\SftpStorage;


use App\Component\SftpStorage\FileWrapper\FileWrapperInterface;
use RuntimeException;

class SftpStorage
{
    private const DEFAULT_DIR_MODE = 0755;
    private const DEFAULT_FILE_MODE = 0644;
    private Config $config;

    /**
     * @var resource
     */
    private $connection;

    /**
     * @var resource
     */
    private $sftp;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->connect();
    }

    public function store(FileWrapperInterface $file): void
    {
        $src = $file->getFileInfo()->getPathname();
        $dst = $file->getDirsHierarchyToSave();
        array_unshift($dst, $this->config->getDataDirectory());
        $dstdir = join('/', $dst);
        $dir_exists = is_dir('ssh2.sftp://' . $this->sftp . $dstdir);
        if (!$dir_exists) {
            $result = ssh2_sftp_mkdir($this->sftp, $dstdir, self::DEFAULT_DIR_MODE, true);
            if (!$result) {
                $dir_exists = is_dir('ssh2.sftp://' . $this->sftp . $dstdir);
                if (!$dir_exists) {
                    throw new RuntimeException(sprintf('unable to create destination directory: %s', $dstdir));
                }
            }
        }
        array_push($dst, $file->getFilenameToSave());
        $dst = join('/', $dst);
        $file_exists = is_file('ssh2.sftp://' . $this->sftp . $dst);
        if (!$file_exists) {
            $result = ssh2_scp_send($this->connection, $src, $dst, self::DEFAULT_FILE_MODE);
            if (!$result) {
                $file_exists = is_file('ssh2.sftp://' . $this->sftp . $dst);
                if (!$file_exists) {
                    throw new RuntimeException(sprintf('unable to store file: %s', $dst));
                }
            }
        }

    }

    public function recheck(FileWrapperInterface $file): void
    {
        $dst = $file->getDirsHierarchyToSave();
        array_unshift($dst, $this->config->getDataDirectory());
        array_push($dst, $file->getFilenameToSave());
        $dst = join('/', $dst);
        $tmp_handle = tmpfile();
        $meta = stream_get_meta_data($tmp_handle);
        $path = $meta['uri'];
        $result = ssh2_scp_recv($this->connection, $dst, $path);
        if (!$result) {
            throw new RuntimeException('recheck: unable to receive remote file');
        }
        $hash = md5_file($path);
        if ($hash !== $file->getHash()) {
            throw new RuntimeException('recheck: file hashes mismatch');
        }
    }

    private function connect()
    {
        $connection = ssh2_connect(
            $this->config->getHost(),
            $this->config->getPort(),
            $this->config->getMethods(),
            $this->config->getCallbacks()
        );
        if (!is_resource($connection)) {
            throw new RuntimeException('unable to ssh2_connect');
        }
        $this->connection = $connection;
        $fingerprint = ssh2_fingerprint($this->connection, SSH2_FINGERPRINT_MD5 | SSH2_FINGERPRINT_HEX);
        if (strcmp($this->config->getFingerprint(), $fingerprint) !== 0) {
            throw new RuntimeException('unable to verify server identity');
        }
        $this->auth();
        $sftp = ssh2_sftp($this->connection);
        if (!is_resource($sftp)) {
            throw new RuntimeException('unable to connect sftp');
        }
        $this->sftp = $sftp;
    }

    private function getcwd()
    {
        return ssh2_sftp_realpath($this->sftp, '.');
    }

    protected function auth()
    {
        if (!ssh2_auth_pubkey_file(
            $this->connection,
            $this->config->getUsername(),
            $this->config->getPublicKeyPath(),
            $this->config->getPrivateKeyPath()
        )) {
            throw new RuntimeException('autentication rejected by server');
        }
    }

    public function disconnect()
    {
        if (is_resource($this->connection)) {
            $this->sftp = null;
            $disconnect = ssh2_disconnect($this->connection);
            if (!$disconnect) {
                throw new RuntimeException('unable to disconnect ssh connection');
            }
        }
    }

    public function __destruct()
    {
        $this->sftp = null;
        $this->disconnect();
    }
}