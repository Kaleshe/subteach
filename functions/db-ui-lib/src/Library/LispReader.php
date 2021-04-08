<?php


namespace Library;

/*
 * TODO:
 * 1. Quotes (')
 * 2. Literals
 * 3. Backtick quotes &
 */

use Closure;

class LispReader
{
    public static function from(string $original_string)
    {
        /** @var Lisp $lisp_string */
        $lisp_string = self::strToLisp($original_string);
        return self::parseToken($lisp_string)->asLisp();
    }

    private static function strToLisp(string $original_string): Lisp
    {
        $reversed = strrev($original_string);
        $lisp_string = new Lisp(null, null);
        $len = strlen($reversed);
        for ($i = 0; $i < $len; $i++) {
            $each = $reversed[$i];
            $is_first = $lisp_string->isNil();
            if ($is_first) {
                $lisp_string = new Lisp($each);
            } else {
                $lisp_string = new Lisp($each, $lisp_string);
            }
        }
        return $lisp_string;
    }

    private static function parseToken(Lisp $lisp_string)
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$lisp_token, $_] = self::parseTokenWithRemaining($lisp_string);
        return $lisp_token;
    }

    private static function skipWhitespace(Lisp $lisp_string)
    {
        while (self::isWhitespace($lisp_string)) {
            $lisp_string = $lisp_string->getRest();
        }
        return $lisp_string;
    }

    private static function isWhitespace(?Lisp $lisp_string) : bool
    {
        if ($lisp_string === null || !$lisp_string->hasFirst()) {
            return false;
        }
        $first = $lisp_string->getFirst();
        return preg_match('/[[:space:],]/', $first) === 1;
    }

    private static function parseLisp(Lisp $characters)
    {
        $characters = self::skipOpenParensThenWhitespace($characters);

        $children = Lisp::nil();

        while (!$characters->isNil() && $characters->getFirst() !== ")") {
            [$next, $characters] = self::parseTokenWithRemaining($characters);
            $children = new Lisp($next, $children);
            $characters = self::skipWhitespace($characters);
        }
        $characters = self::skipClosingParensThenWhitespace($characters);
        return [Reference::createLisp($children->reversed()), $characters];
    }

    private static function isLiteralFirstChar($ch) : bool
    {
        return preg_match('/[[:alpha:]_:]/', $ch) === 1;
    }

    /**
     * @return Closure
     * @noinspection PhpUnusedParameterInspection
     */
    private static function getParser(Lisp $characters): Closure
    {
        $next = $characters->getFirst();
        if ($next === "(") {
//            print("# Returning Lisp parser\n");
            return function ($characters) {
                return self::parseLisp($characters);
            };
        }

        if ($next === '"') {
//            print("# Parse string\n");
            return function ($characters) {
                return self::parseString($characters);
            };
        }

        if (self::isLiteralFirstChar($next)) {
//            print("# Parse literal\n");
            return function ($characters) {
                return self::parseLiteral($characters);
            };
        }

        if (is_numeric($next)) {
//            print("# Parse numeric\n");
            return function ($characters) {
                return self::parseNumeric($characters);
            };
        }

//        print("# Returning empty parser");
        return function ($characters) {
            return [Lisp::nil(), Lisp::nil()];
        };
    }

    private static function skipOpenParensThenWhitespace(Lisp $characters): Lisp
    {
        return self::skipCharacterThenWhitespace($characters, '(');
    }

    private static function skipClosingParensThenWhitespace(?Lisp $characters)
    {
        return self::skipCharacterThenWhitespace($characters, ')');
    }

    /**
     * @param Lisp $lisp_string
     * @return mixed
     */
    private static function parseTokenWithRemaining(Lisp $lisp_string)
    {
        $lisp_string = self::skipWhitespace($lisp_string);
        $parser = self::getParser($lisp_string);
        $result = $parser($lisp_string);
//        print("# Parser result ...");
//        [$val, $chars] = $result;
//        print("{val = $val}, {chars = $chars}");
//        print("<<< end result\n");
        return $result;
    }

    private static function parseString($characters)
    {
        if ($characters->getFirst() !== '"') {
            return [Lisp::nil(), Lisp::nil()];
        }
        $characters = $characters->getRest();
        $string_buffer = "";
        while ($characters->getFirst() !== '"' && !$characters->isNil()) {
            $string_buffer .= $characters->getFirst();
            $characters = $characters->getRest();
        }
        $characters = $characters->getRest();
        return [Reference::createString($string_buffer), $characters];
    }

    private static function parseNumeric(Lisp $characters)
    {
        for ($numeric = ''; is_numeric($characters->getFirst()); $characters = $characters->getRest()) {
            $numeric .= $characters->getFirst();
        }

        return [Reference::createInteger(intval($numeric)), $characters];
    }

    /**
     * @param Lisp $characters
     * @param string $skip_character
     * @return Lisp|null
     */
    private static function skipCharacterThenWhitespace(Lisp $characters, string $skip_character): ?Lisp
    {
        if ($characters->getFirst() !== $skip_character) {
            return Lisp::nil();
        }
        return self::skipWhitespace($characters->getRest());
    }

    private static function parseLiteral(Lisp $characters)
    {
        $literal = $characters->getFirst();
        $characters = $characters->getRest();
//        print("###LITERAL = $literal\n");
        while (self::isLiteralChar($characters->getFirst())) {
            $literal .= $characters->getFirst();
            $characters = $characters->getRest();
        }
//        print("### Returning {literal=$literal}\n");
        return [Reference::createLiteral($literal), $characters];
    }

    private static function isLiteralChar($char)
    {
        return self::isLiteralFirstChar($char) || preg_match('/[-[:digit:]]/', $char) === 1;
    }
}