<?php


namespace Library;


class Lisp
{
    /** @var ?mixed */
    private $first;
    /** @var Lisp */
    private $rest;
    /** @var ?Lisp */
    private static $nil;

    public static function nil(): Lisp
    {
        if (self::$nil === null) {
            self::$nil = new Lisp(null);
        }
        return self::$nil;
    }

    public function getValue($key)
    {
        for ($ptr = $this; !$ptr->isNil(); $ptr = $ptr->nth(2)) {
            if ($ptr->hasFirstLiteral() && $ptr->getFirstLiteral() === $key && $ptr->hasMore()) {
                return $ptr->get(1);
            }
        }
        return Lisp::nil();
    }

    public function reversed(): Lisp
    {
        $reversed = new Lisp($this->getFirst());
        for ($each = $this->getRest(); !$each->isNil(); $each = $each->getRest()) {
            $reversed = new Lisp($each->getFirst(), $reversed);
        }
        return $reversed;
    }

    /**
     * Lisp constructor.
     * @param ?mixed $first
     * @param ?Lisp $rest
     */
    public function __construct($first, Lisp $rest = null)
    {
        $this->first = $first;
        $this->rest = $rest;
    }

    private static function notNil(?Lisp $each)
    {
        return $each !== null && !$each->isNil();
    }

    public function getFirst()
    {
        return $this->first;
    }

    public function getFirstLiteral(): string
    {
        return $this->getFirst()->asLiteral();

    }

    public function getRest(): Lisp
    {
        if ($this->rest == null) {
            return new Lisp(null);
        }
        return $this->rest;
    }


    public function __toString(): string
    {
        if ($this->isNil()) {
            return "NIL";
        }
        return "(" . $this->elementsAsString() . ")";
    }

    public function hasFirst(): bool
    {
        return $this->first !== null;
    }

    public function hasMore(): bool
    {
        return $this->rest !== null && !$this->rest->isNil();
    }

    public function getLispNamed($literal)
    {
        for ($ptr = $this; !$ptr->isNil(); $ptr = $ptr->getRest()) {
            if ($ptr->hasLispAt(0) && $ptr->getFirstLisp()->hasFirstLiteralNamed($literal)) {
                return $ptr->getFirstLisp();
            }
        }
        return Lisp::nil();
    }

    public function isNil(): bool
    {
        return !$this->hasFirst() && !$this->hasMore();
    }

    private function elementsAsString(): string
    {

        $str = $this->getFirstString();
        for ($each = $this->getRest(); self::notNil($each); $each = $each->getRest()) {
            $str .= " " . $each->getFirstString();
        }
        return $str;
    }

    /**
     * @param $each
     * @return string
     */
    private function getFirstString(): string
    {
        return strval($this->getFirst());
    }

    public function get(int $index)
    {
        return $this->nth($index)->getFirst();
    }

    public function getLiteralAt(int $index)
    {
        return $this->get($index)->asLiteral();
    }

    public function getFirstLisp(): Lisp
    {
        return $this->getFirst()->asLisp();
    }

    public function getStringAt(int $index)
    {
        return $this->get($index)->asString();
    }

    public function nth(int $index): Lisp
    {
        $ptr = $this;
        for ($i = 0; $i < $index && !$ptr->isNil(); $i++) {
            $ptr = $ptr->getRest();
        }
        return $ptr;
    }

    private function hasLispAt(int $index)
    {
        /** @var Reference $reference */
        $reference = $this->get($index);
        return $reference->isLisp();
    }

    private function hasFirstLiteral()
    {
        return $this->hasFirst() && $this->getFirst()->isLiteral();
    }

    private function hasFirstLiteralNamed($literal)
    {
        return $this->hasFirstLiteral() && $this->getFirstLiteral() === $literal;
    }
}