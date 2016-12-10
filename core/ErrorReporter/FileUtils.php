<?php

namespace Core\ErrorReporter;

use SplFileObject;

class FileUtils
{
    /**
     * @param string $filePath
     * @param int $line
     * @param int $fetchLineCount
     * @return array
     */
    public static function getLines($filePath, $line, $fetchLineCount)
    {
        $lines = [];

        $startLine = $line > 0 ? $line : 0;
        $endLine = $startLine + $fetchLineCount;

        $file = new SplFileObject($filePath);
        $file->setFlags(SplFileObject::DROP_NEW_LINE);
        $file->seek($startLine);

        for ($i = $startLine; $i < $endLine; $i++) {
            $line = $file->current();

            if ($line === false) {
                break;
            }

            $lines[$i] = $line;
            $file->next();
        }

        return $lines;
    }
}