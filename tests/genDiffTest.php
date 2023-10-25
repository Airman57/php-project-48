<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    /**
    * @dataProvider provideGenDiffData
    */
    public function testGenDiff(string $expectedPath, string $file1Path, string $file2Path, string $format)
    {
        $file1 = $this->getPath($file1Path);
        $file2 = $this->getPath($file2Path);
        $expected = $this->getPath($expectedPath);
        $comparison = genDiff($file1, $file2, $format);
        $this->assertStringEqualsFile($expected, $comparison);
    }

    private function getPath(string $path)
    {
        return "tests/fixtures/" . $path;
    }

    public static function provideGenDiffData()
    {
        return [
            'recursive json as stylish' => [
                'expectedPath' => "CompareRecursiveStylish.txt",
                'file1Path' => "bigFile1.json",
                'file2Path' => "bigFile2.json",
                'format' => "stylish"
            ],
            'recursive yaml as stylish' => [
                'expectedPath' => "CompareRecursiveStylish.txt",
                'file1Path' => "file1.yaml",
                'file2Path' => "file2.yaml",
                'format' => "stylish"
            ],
            'recursive json as plain' => [
                'expectedPath' => "CompareRecursivePlain.txt",
                'file1Path' => "bigFile1.json",
                'file2Path' => "bigFile2.json",
                'format' => "plain"
            ],
            'recursive yaml as plain' => [
                'expectedPath' => "CompareRecursivePlain.txt",
                'file1Path' => "file1.yaml",
                'file2Path' => "file2.yaml",
                'format' => "plain"
            ],
            'recursive json as json' => [
                'expectedPath' => "CompareRecursiveJson.txt",
                'file1Path' => "bigFile1.json",
                'file2Path' => "bigFile2.json",
                'format' => "json"
            ],
            'recursive yaml as json' => [
                'expectedPath' => "CompareRecursiveJson.txt",
                'file1Path' => "file1.yaml",
                'file2Path' => "file2.yaml",
                'format' => "json"
            ],
            'flat yml as stylish' => [
                'expectedPath' => "Compare.txt",
                'file1Path' => "smallFile1.yml",
                'file2Path' => "smallFile2.yml",
                'format' => "stylish"
            ],
            'flat json as stylish' => [
                'expectedPath' => "Compare.txt",
                'file1Path' => "file1.json",
                'file2Path' => "file2.json",
                'format' => "stylish"
            ]
        ];    
    }       
}
