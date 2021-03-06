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
 * Class TwigGlobals | App/Models/TwigGlobals.php
 *
 * @package     funombi\App\Models
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace App\Models;

use Core\Model;

/**
 * Used to auto-append custom globals into Twig.
 * All function created here should return an array.
 * 
 * 
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class TwigGlobals extends Model
{

    /**
     * List of globals to set into Twig.
     * @var array List of globals 
     */
    public $globals = array();

    /**
     * This call all methods and add the results into $globals.
     */
    public function __construct()
    {
        $modelFunction = get_class_methods('\Core\Model');
        $methods       = get_class_methods($this);

        $autorised = array_diff($methods, $modelFunction);
        unset($autorised[0]);

        foreach ($methods as $method) {
            if (in_array($method, $autorised)) {
                $this->globals = array_merge($this->globals, $this->$method());
            }
        }
    }

}
