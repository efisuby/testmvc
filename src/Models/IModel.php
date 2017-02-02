<?php

namespace App\Models;

interface IModel
{
    public static function getTable();
    public static function getSchema();
}