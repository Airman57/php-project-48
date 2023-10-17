<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    public function testGenDiff()
    {
        $expected0 = file_get_contents('./tests/fixtures/CompareRecursiveStylish.txt');
        $this->assertEquals($expected0, genDiff('./tests/fixtures/bigFile1.json', './tests/fixtures/bigFile2.json', 'stylish'));
        $this->assertEquals($expected0, genDiff('./tests/fixtures/file1.yaml', './tests/fixtures/file2.yaml', 'stylish'));

        $expected1 = file_get_contents('./tests/fixtures/CompareRecursivePlain.txt');
        $this->assertEquals($expected1, genDiff('./tests/fixtures/bigFile1.json', './tests/fixtures/bigFile2.json', 'plain'));
        $this->assertEquals($expected1, genDiff('./tests/fixtures/file1.yaml', './tests/fixtures/file2.yaml', 'plain'));

        $expected2 = file_get_contents('./tests/fixtures/CompareRecursiveJson.txt');
        $this->assertEquals($expected2, genDiff('./tests/fixtures/bigFile1.json', './tests/fixtures/bigFile2.json', 'json'));
        $this->assertEquals($expected2, genDiff('./tests/fixtures/file1.yaml', './tests/fixtures/file2.yaml', 'json'));

        $expected3 = file_get_contents('./tests/fixtures/Compare.txt');
        $this->assertEquals($expected3, genDiff('./tests/fixtures/file1.json', './tests/fixtures/file2.json'));
        $this->assertEquals($expected3, genDiff('./tests/fixtures/smallFile1.yml', './tests/fixtures/smallFile2.yml'));
    }
}
