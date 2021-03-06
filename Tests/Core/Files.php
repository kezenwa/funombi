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
 * Class Files | Tests/Core/Files.php
 *
 * @package     funombi\Core\tests
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace Core\tests\units;

use atoum;
use Core\Files as classToTest;
use App\Config\Locations;

/**
 * Tests for Core\Files()
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
class Files extends atoum
{

    /**
     * Give the valid root path
     * 
     * @return string
     */
    private static function Root()
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;
    }

    /**
     * Test Files::getRoot()
     */
    public function testGetRoot()
    {

        $currentRoot = static::Root();
        $falseRoot   = $currentRoot . 'Core' . DIRECTORY_SEPARATOR;

        $this
                ->given($files = new classToTest())
                ->then
                ->string($files::getRoot())
                ->isNotEmpty()
                ->isEqualTo($currentRoot)
                ->isNotEqualTo($falseRoot)
        ;
    }

    /**
     * Test Files::checkVitalDirectories()
     */
    public function testCheckVitalDirectories()
    {
        $currentRoot = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;
        $public      = Locations::PUBLIC_DIR . DIRECTORY_SEPARATOR;
        $images      = $public . Locations::IMAGES;
        $renameWith  = $public . 'helloworld';

        if (classToTest::isDir($renameWith)) {
            rename($currentRoot . $renameWith, $currentRoot . $images);
        }

        $this
                ->given($check = new classToTest())
                ->if(classToTest::isDir($images))
                ->and(
                        rename($currentRoot . $images, $currentRoot . $renameWith)
                )
                ->then
                ->exception(function() use($check) {
                    $check::checkVitalDirectories();
                })
                ->hasMessage("The (vital) directory '$images' is not found")
        ;

        rename($currentRoot . $renameWith, $currentRoot . $images);

        $this
                ->given($check = new classToTest())
                ->then
                ->boolean($check::checkVitalDirectories())->isTrue()
                ->exception(function() use($check) {
                    $check::checkVitalDirectories(array('testdir'));
                })
                ->hasMessage("The (vital) directory 'public/testdir' is not found")
        ;
    }

    /**
     * Test Files::matchExtensionToFileSystem()
     */
    public function testMatchExtensionToFileSystem()
    {
        $fileToMatch = 'hello.css';
        $trueResult  = Locations::STYLESHEETS;

        $fileToMatch2 = 'hello.world';

        $this
                ->given($match = new classToTest())
                ->then
                ->string($match::matchExtensionToFileSystem($fileToMatch))->isEqualTo($trueResult)
                ->exception(function() use ($match, $fileToMatch2) {
                    $match::matchExtensionToFileSystem($fileToMatch2);
                })->hasMessage("The extension of $fileToMatch2 is not accepted.")
        ;
    }

    /**
     * Test Files::createLinkToFile()
     */
    public function testCreateLinkToFile()
    {
        
    }

    /**
     * Test Files::isFile()
     */
    public function testIsFile()
    {
        $currentRoot = static::Root();

        $this
                        ->given($isFile = new classToTest())
                        ->then
                        ->boolean($isFile::isFile($currentRoot . 'Core' . DIRECTORY_SEPARATOR . 'Arrays.php'))->isTrue
                        ->boolean($isFile::isFile($currentRoot . 'Core' . DIRECTORY_SEPARATOR . 'HelloWorld.php'))->isFalse
        ;
    }

    /**
     * Test Files::isDir()
     */
    public function testIsDir()
    {
        $currentRoot = static::Root();

        $this
                        ->given($isDir = new classToTest())
                        ->then
                        ->boolean($isDir::isDir($currentRoot . 'Core'))->isTrue
                        ->boolean($isDir::isDir($currentRoot . 'Hello'))->isFalse
        ;
    }

    /**
     * Test Files::hashFile()
     */
    public function testHashFile()
    {
        $currentRoot = static::Root();
        $path        = $currentRoot . 'App' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Errors.php';

        $trueHash = 'a2909f2a83d2e44c7c30ac096e22cc4f5c7a75a1aaae4a2475f2c168fc20d38291621177dcff929c323b4795008a964af57d0d29a8dc8714ec12f3b3bb75f2e5';

        $this
                ->given($hash = new classToTest())
                ->then
                ->string($hash::hashFile($path))->isEqualTo($trueHash)
        ;
    }

    /**
     * Test Files::isHashSameAsSystem()
     */
    public function testIsHashSameAsSystem()
    {
        $currentRoot = static::Root();
        $path        = $currentRoot . 'App' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Errors.php';

        $falsePath = $currentRoot . 'Tests/Core/Files.php';
        $this
                ->given($files     = new classToTest())
                ->then
                ->boolean($files::isHashSameAsSystem($path))->isTrue
                ->boolean($files::isHashSameAsSystem($falsePath))
        ;
    }

    /**
     * Test Files::writeDatabaseConfig()
     */
    public function testWriteDatabaseConfig()
    {
        $pathToFile  = classToTest::getRoot() . 'App/Config/Database.php';
        $currentHash = classToTest::hashFile($pathToFile);

        $newData = array(
            'host'     => 'Hello',
            'name'     => 'World',
            'user'     => 'Iam',
            'password' => 'WhoIAm',
            'prefix'   => 'hi_'
        );

        $falseData = array(
            'Hello',
            'World',
            'Iam',
            'WhoIAm',
            'hi_',
        );


        $this
                ->given($files = new classToTest())
                ->then
                ->boolean($files::writeDatabaseConfig($newData))->isTrue()
                ->boolean($files::writeDatabaseConfig($falseData))->isFalse()
                ->boolean($files::isHashSameAsSystem($pathToFile))->isFalse()
        ;

        static::temporaryChangeContent($pathToFile, false);


        $this
                ->given($files = new classToTest())
                ->then
                ->boolean($files::writeDatabaseConfig($newData))->isFalse()
        ;

        chmod($pathToFile, 0644);
        $this
                ->given($file  = new classToTest())
                ->then
                ->boolean($file::writeDatabaseConfig($newData))->isFalse()
        ;

        chmod($pathToFile, 0677);
        static::temporaryChangeContent($pathToFile, true);

        $this
                ->given($file  = new classToTest())
                ->then
                ->boolean($file::writeDefaultDatabaseConfig())->isTrue()
                ->boolean($files::isHashSameAsSystem($pathToFile))->isTrue()
        ;
    }

    /**
     * Used to change the content of App\Config\Database()
     * 
     * @param string $path
     * @param boolean $reverse
     * @return boolean
     */
    private static function temporaryChangeContent($path, $reverse = false)
    {
        $currentFile = file_get_contents($path);

        if ($reverse) {
            $currentFile = preg_replace('/hello/', 'your', $currentFile);
        } else {
            $currentFile = preg_replace('/your/', 'hello', $currentFile);
        }
        if (file_put_contents($path, $currentFile)) {
            return false;
        }
        return true;
    }

}
