<?php
namespace Centerpoint\Reader\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

Abstract class BaseRepository {

    abstract function model();
}