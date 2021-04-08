<?php


namespace Library;


class Reference
{
    private $value;
    private $type;

    private function __construct($value, $type)
    {
        $this->value = $value;
        $this->type = $type;
    }

    public static function createString($value)
    {
        return new Reference($value, 'string');
    }

    public static function createInteger($value)
    {
        return new Reference($value, 'integer');
    }

    public static function createLiteral($value)
    {
        return new Reference($value, 'literal');
    }

    public static function createLisp($value)
    {
        return new Reference($value, 'lisp');
    }

    public function isString(): bool
    {
        return $this->type === 'string';
    }

    public function asString(): string
    {
        return $this->value;
    }

    public function isInteger(): bool
    {
        return $this->type === 'integer';
    }

    public function asInteger(): int
    {
        return $this->value;
    }

    public function isLiteral(): bool
    {
        return $this->type === 'literal';
    }

    public function asLiteral(): string
    {
        return $this->value;
    }

    public function isLisp(): bool
    {
        return $this->type === 'lisp';
    }

    public function asLisp(): Lisp
    {
        return $this->value;
    }

    public function __toString()
    {
        if ($this->isString()) {
            return '"' . addslashes($this->value) . '"';
        }
        if ($this->isLiteral()) {
            return $this->value;
        }
        return strval($this->value);
    }


}