<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 26.01.2019
 * Time: 15:35
 */

namespace App\Traits\EntityFields;

trait CreatedAtLastModified
{
    use CreatedAt, LastModified;
}
