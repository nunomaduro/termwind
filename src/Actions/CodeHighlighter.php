<?php

declare(strict_types=1);

namespace Termwind\Actions;

use Termwind\Termwind;

/**
 * @internal
 */
final class CodeHighlighter
{
    public const TOKEN_DEFAULT = 'token_default';
    public const TOKEN_COMMENT = 'token_comment';
    public const TOKEN_STRING = 'token_string';
    public const TOKEN_HTML = 'token_html';
    public const TOKEN_KEYWORD = 'token_keyword';
    public const ACTUAL_LINE_MARK = 'actual_line_mark';
    public const LINE_NUMBER = 'line_number';

    private const ARROW_SYMBOL = '>';
    private const DELIMITER = '|';
    private const ARROW_SYMBOL_UTF8 = '➜';
    private const DELIMITER_UTF8 = '▕'; // '▶';
    private const LINE_NUMBER_DIVIDER = 'line_divider';
    private const MARKED_LINE_NUMBER = 'marked_line';
    private const WIDTH = 3;

    /**
     * Holds the theme.
     *
     * @var array<string, string>
     */
    private const THEME = [
        self::TOKEN_STRING => 'text-gray',
        self::TOKEN_COMMENT => 'text-gray italic',
        self::TOKEN_KEYWORD => 'text-magenta font-bold',
        self::TOKEN_DEFAULT => 'font-bold',
        self::TOKEN_HTML => 'text-blue font-bold',

        self::ACTUAL_LINE_MARK => 'text-red font-bold',
        self::LINE_NUMBER => 'text-gray',
        self::MARKED_LINE_NUMBER => 'italic font-bold',
        self::LINE_NUMBER_DIVIDER => 'text-gray',
    ];

    private string $delimiter = self::DELIMITER_UTF8;
    private string $arrow = self::ARROW_SYMBOL_UTF8;
    private const NO_MARK = '    ';

    /**
     * Creates an instance of the Highlighter.
     */
    public function __construct(bool $UTF8 = true)
    {
        if (! $UTF8) {
            $this->delimiter = self::DELIMITER;
            $this->arrow = self::ARROW_SYMBOL;
        }

        $this->delimiter .= ' ';
    }

    /**
     * Highlights the provided content.
     */
    public function highlight(string $content, int $line, int $startLine = 1): string
    {
        $tokenLines = $this->getHighlightedLines(trim($content, "\n"), $startLine);

        $lines = $this->colorLines($tokenLines);
        $lines = $this->lineNumbers($lines, $line);

        return rtrim($lines);
    }

    /**
     * Returns content split into lines with numbers
     *
     * @return array<int, array<int, string>>
     */
    private function getHighlightedLines(string $source, int $startLine): array
    {
        $source = str_replace(["\r\n", "\r"], "\n", $source);
        $tokens = $this->tokenize($source);

        return $this->splitToLines($tokens, $startLine - 1);
    }

    /**
     * @return array<int, array<int, string>>
     */
    private function tokenize(string $source): array
    {
        $tokens = token_get_all($source);

        $output = [];
        $currentType = null;
        $buffer = '';

        foreach ($tokens as $token) {
            if (is_array($token)) {
                switch ($token[0]) {
                    case T_WHITESPACE:
                        break;

                    case T_OPEN_TAG:
                    case T_OPEN_TAG_WITH_ECHO:
                    case T_CLOSE_TAG:
                    case T_STRING:
                    case T_VARIABLE:
                        // Constants
                    case T_DIR:
                    case T_FILE:
                    case T_METHOD_C:
                    case T_DNUMBER:
                    case T_LNUMBER:
                    case T_NS_C:
                    case T_LINE:
                    case T_CLASS_C:
                    case T_FUNC_C:
                    case T_TRAIT_C:
                        $newType = self::TOKEN_DEFAULT;
                        break;

                    case T_COMMENT:
                    case T_DOC_COMMENT:
                        $newType = self::TOKEN_COMMENT;
                        break;

                    case T_ENCAPSED_AND_WHITESPACE:
                    case T_CONSTANT_ENCAPSED_STRING:
                        $newType = self::TOKEN_STRING;
                        break;

                    case T_INLINE_HTML:
                        $newType = self::TOKEN_HTML;
                        break;

                    default:
                        $newType = self::TOKEN_KEYWORD;
                }
            } else {
                $newType = $token === '"' ? self::TOKEN_STRING : self::TOKEN_KEYWORD;
            }

            if ($currentType === null) {
                $currentType = $newType;
            }

            if ($currentType !== $newType) {
                $output[] = [$currentType, $buffer];
                $buffer = '';
                $currentType = $newType;
            }

            $buffer .= is_array($token) ? $token[1] : $token;
        }

        if (isset($newType)) {
            $output[] = [$newType, $buffer];
        }

        return $output;
    }

    private function splitToLines(array $tokens, int $startLine): array
    {
        $lines = [];

        $line = [];
        foreach ($tokens as $token) {
            foreach (explode("\n", $token[1]) as $count => $tokenLine) {
                if ($count > 0) {
                    $lines[$startLine++] = $line;
                    $line = [];
                }

                if ($tokenLine === '') {
                    continue;
                }

                $line[] = [$token[0], $tokenLine];
            }
        }

        $lines[$startLine++] = $line;

        return $lines;
    }

    private function colorLines(array $tokenLines): array
    {
        $lines = [];
        foreach ($tokenLines as $lineCount => $tokenLine) {
            $line = '';

            foreach ($tokenLine as $token) {
                [$tokenType, $tokenValue] = $token;
                $line .= $this->styleToken($tokenType, $tokenValue);
            }

            $lines[$lineCount] = $line;
        }


        return $lines;
    }

    /**
     * @param  int|null  $markLine
     */
    private function lineNumbers(array $lines, $markLine = null): string
    {
        $lineStrlen = strlen((string) (array_key_last($lines) + 1));
        $lineStrlen = $lineStrlen < self::WIDTH ? self::WIDTH : $lineStrlen;
        $snippet = '';
        $mark = '  '.$this->arrow.' ';
        foreach ($lines as $i => $line) {
            $coloredLineNumber = $this->coloredLineNumber(self::LINE_NUMBER, $i, $lineStrlen);

            if (null !== $markLine) {
                $snippet .= ($markLine === $i + 1
                    ? $this->styleToken(self::ACTUAL_LINE_MARK, $mark)
                    : self::NO_MARK
                );

                $coloredLineNumber = ($markLine === $i + 1 ?
                    $this->coloredLineNumber(self::MARKED_LINE_NUMBER, $i, $lineStrlen) :
                    $coloredLineNumber
                );
            }
            $snippet .= $coloredLineNumber;

            $snippet .= $this->styleToken(self::LINE_NUMBER_DIVIDER, $this->delimiter);

            $snippet .= $line.PHP_EOL;
        }

        return $snippet;
    }

    private function coloredLineNumber(string $style, int $i, int $lineStrlen): string
    {
        return $this->styleToken($style, str_pad((string) ($i + 1), $lineStrlen, ' ', STR_PAD_LEFT));
    }

    private function styleToken(string $token, string $string): string
    {
        if (! isset(self::THEME[$token])) {
            return $string;
        }

        return (string) Termwind::span($string, self::THEME[$token]);
    }
}
