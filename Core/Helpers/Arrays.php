<?php

/*
 * The MIT License
 *
 * Copyright 2017 Nissar Chababy <contact at funilrys dot com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Class Arrays | Core/Helpers/Arrays.php
 *
 * @package     funombi\Core\Helpers
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace Core\Helpers;

/**
 * Helper of Core\Arrays.
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Arrays
{

    /**
     * The following helps to flatten an array when 
     * Core\Arrays::flattenKeysRecursively() is called.
     * 
     * @param array $array The array to flatten
     * @param array $result Where the result goes
     * @param string $parentKey The parent key to assign
     * @return void
     */
    public static function flattenKeyRecursively(array $array, array &$result, string $parentKey)
    {
        foreach ($array as $key => $value) {
            $itemKey = ($parentKey ? $parentKey . '.' : '') . $key;
            if (is_array($value)) {
                static::flattenKeyRecursively($value, $result, $itemKey);
            } else {
                $result[$itemKey] = $value;
            }
        }
    }

}
