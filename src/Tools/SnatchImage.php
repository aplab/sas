<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 30.10.2015
 * Time: 2:04
 */

namespace App\Tools;

use Exception;

class SnatchImage
{
    /**
     * @param string $path
     * @return false|resource
     * @throws Exception
     */
    public static function snatch(string $path)
    {
        $path        = str_replace(' ', '%20', $path);
        $curl        = curl_init();
        $tmp_handle  = tmpfile();
        $meta        = stream_get_meta_data($tmp_handle);
        $cookie_path = $meta['uri'];
        curl_setopt_array($curl, array(
            CURLOPT_URL            => $path,
            CURLOPT_MAXREDIRS      => 20,
            CURLOPT_COOKIEJAR      => $cookie_path,
            CURLOPT_COOKIEFILE     => $cookie_path,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0'
        ));
        //curl_setopt($curl, CURLOPT_PROXY, concat_ws(':', $proxy_host, $proxy_port));
        $image_string = curl_exec($curl);
        //$image_string = Misc::curl_exec_follow($curl);
        $curl_info         = curl_getinfo($curl);
        $curl_error_text   = curl_error($curl);
        $curl_error_number = curl_errno($curl);

        if ($curl_error_number != 0) {
            throw new Exception('Unable to download remote image');
        }
        if ($curl_info['http_code'] != 200) {
            throw new Exception('Unable to download remote image http error');
        }

        if (!$image_string) {
            throw new Exception('Unable to download remote image');
        }
        $tmp_handle = tmpfile();
        $meta       = stream_get_meta_data($tmp_handle);
        $tmp_path   = $meta['uri'];
        file_put_contents($tmp_path, $image_string);
        $extension = strtolower(substr(strrchr($path, "."), 1));

        switch ($extension) {
            case 'png' :
                $image    = imagecreatefrompng($tmp_path);
                $img_info = getimagesize($tmp_path);
                break;
            case 'gif' :
                $image    = imagecreatefromgif($tmp_path);
                $img_info = getimagesize($tmp_path);
                break;
            case 'jpeg':
            case 'jpg' :
                $image    = imagecreatefromjpeg($tmp_path);
                $img_info = getimagesize($tmp_path);
                break;
            default :
                $image    = imagecreatefromstring($image_string);
                $img_info = getimagesizefromstring($image_string);
                break;
        }
//        $image = imagecreatefromstring($image_string);
//        $img_info = getimagesizefromstring($image_string);
        /**
         * Сначала создаем изображение поддерживаеиого типа а потом уже
         * выполняем getimagesize.
         * см. http://habrahabr.ru/post/224351/
         */
        if (!is_resource($image)) {
//            try {
//                $imagick = new \Imagick($tmp_path);
//            } catch (\ImagickException $e) {
//                Tools::dump($image_string);
//            }

            if (!is_resource($image)) {
                throw new Exception('Unable to create image from source data');
            }
        }
        if (false === $img_info) {
            throw new Exception('Unable to get image size from source data');
        }
        $width  = imagesx($image);
        $height = imagesy($image);
        if ($width !== $img_info[0]) {
            throw new Exception('Wrong width');
        }
        if ($height !== $img_info[1]) {
            throw new Exception('Wrong height');
        }
        if (!$width) {
            throw new Exception('Empty width');
        }
        if (!$height) {
            throw new Exception('Empty height');
        }
        switch (strtolower($img_info['mime'])) {
            case 'image/jpeg' :
                $extension = 'jpg';
                break;
            case 'image/png' :
                $extension = 'png';
                break;
            case 'image/gif' :
                $extension = 'gif';
                break;
            default :
                throw new Exception('Unsupported mime');
        }
        $image = array(
            'image'     => $image,
            'width'     => $width,
            'height'    => $height,
            'mime'      => $img_info['mime'],
            'extension' => $extension
        );

        $tmp_handle = tmpfile();
        $meta       = stream_get_meta_data($tmp_handle);
        $path       = $meta['uri'];

        switch ($image['extension']) {
            case 'jpg':
                $result = imagejpeg($image['image'], $path);
                break;
            case 'gif':
                $result = imagegif($image['image'], $path);
                break;
            default:
                $result = imagepng($image['image'], $path, 9);
                break;
        }
        if (!$result) {
            throw new Exception('Unable to create image');
        }
        return $tmp_handle;
    }
}
