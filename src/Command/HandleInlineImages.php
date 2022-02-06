<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 01.02.2019
 * Time: 0:32
 */

namespace App\Command;


use Aplab\AplabAdminBundle\Component\Uploader\ImageUploader;
use App\BusinessObject\Club\ClubRepository;
use App\BusinessObject\Contact\ContactRepository;
use App\BusinessObject\Dojo\DojoRepository;
use App\BusinessObject\Person\PersonRepository;
use App\MysqliManager\Connection;
use App\MysqliManager\MysqliManager;
use App\Util\Path;

trait HandleInlineImages
{
    protected function handleInlineImages(string $text, &$images = [])
    {
        $text = preg_replace_callback('/<img.*?>/isu', function ($m) use (&$images) {
            $tag = $m[0];
            $tag = preg_replace('/height="\\d+"/', 'height="auto"', $tag);
            $tag = preg_replace_callback('/src="(.*?)"/isu', function ($s) use (&$images) {
                $uploader = new ImageUploader($this->localStorage, $this->entityManager);
                $url = html_entity_decode($s[1]);
                $url = rawurldecode($url);
                $path = new Path(dirname($this->kernel->getRootDir()), 'www', $url);
                $this->io->writeln(sprintf('found intext image <comment>%s</comment>', $path));
                $result = $uploader->receive($path);
                $this->io->writeln(sprintf('result: <comment>%s</comment>', $result));
                $images[] = $result;
                return 'src="' . $result . '"';
            }, $tag);
            return $tag;
        }, $text);
        return $text;
    }

    protected function handleInlineLinks(string $text, ?MysqliManager $mm = null)
    {
        $text = preg_replace_callback('/<a [^>]+>/isu', function ($m) use($mm) {
            $tag = $m[0];
            $tag = preg_replace_callback('/href="(.*?)"/isu', function ($s) use($mm) {
                $url = $s[1];
                $url = str_replace('ikomatsushima.su', 'ikomatsushima.org', $url);
                if (preg_match('|^http://|isu', $url)) {
                    return 'href="' . $url . '"';
                }
                if (preg_match('|^https://|isu', $url)) {
                    return 'href="' . $url . '"';
                }
                $url = ltrim($url, '/');
                $url = '/' . $url;
                if ($mm instanceof MysqliManager) {

                    $r = new ClubRepository($mm);
                    $id = $r->getIdBySlug($url);
                    if (!is_null($id)) {
                        $url = "/club/$id";
                        $this->io->writeln(sprintf('replaced url: <comment>%s</comment>', $url));
                    }

                    $r = new DojoRepository($mm);
                    $id = $r->getIdBySlug($url);
                    if (!is_null($id)) {

                        $url = "/dojo/$id";
                        $this->io->writeln(sprintf('replaced url: <comment>%s</comment>', $url));

                    } else {

                        $r = new ContactRepository($mm);
                        $id = $r->getIdBySlug($url);
                        if (!is_null($id)) {
                            $url = "/contact/$id";
                            $this->io->writeln(sprintf('replaced url: <comment>%s</comment>', $url));
                        }

                    }

                    $r = new PersonRepository($mm);
                    $id = $r->getIdBySlug($url);
                    if (!is_null($id)) {
                        $url = "/person/$id";
                        $this->io->writeln(sprintf('replaced url: <comment>%s</comment>', $url));
                    }
                }
                return 'href="' . $url . '"';
            }, $tag);
            return $tag;
        }, $text);
        return $text;
    }
}
