<?php

namespace App\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;

class Money implements JsonSerializable
{
    private int $cents;

    private function __construct(int $cents)
    {
        $this->cents = $cents;
    }

    public static function fromCents(int $cents): self
    {
        return new self($cents);
    }

    public static function fromString(string $amount): self
    {
        // Remove currency symbols and whitespace
        $formattedValue = preg_replace('/[^\d,.]/', '', $amount);          
        // Remove pontos de milhar
        $formattedValue = str_replace('.', '', $formattedValue);
        // Substituir vírgula por ponto (força decimal)
        $formattedValue = str_replace(',', '.', $formattedValue);
        
        if (!is_numeric($formattedValue)) {
            throw new InvalidArgumentException("Invalid money format: {$amount}");
        }

        return self::fromFloat((float) $formattedValue);
    }

    public static function formatString(string $value): string {
        // Remover caracteres não numéricos
        $value = preg_replace('/\D/', '', $value);
    
        // Ajustar a posição da vírgula
        if (preg_match('/^(\d{1})$/', $value)) {
            $value = '0,0' . $value;
        }
        if (preg_match('/^00,(\d{1})/', $value)) {
            $value = '0,' . substr($value, -1);
        }
        if (preg_match('/^0(\d)/', $value)) {
            $value = substr($value, -strlen($value) + 1);
        }
        if (preg_match('/(\d)(\d{2})$/', $value)) {
            $value = substr($value, 0, -2) . ',' . substr($value, -2);
        }
        
        // Adicionar pontos como separadores de milhares
        $value = preg_replace('/(?=(\d{3})+(\D))\B/', '.', $value);
    
        return $value;
    }

    public function toCents(): int
    {
        return $this->cents;
    }

    public function add(Money $other): self
    {
        return new self($this->cents + $other->cents);
    }

    public function subtract(Money $other): self
    {
        return new self($this->cents - $other->cents);
    }

    public function equals(Money $other): bool
    {
        return $this->cents === $other->cents;
    }

    public function isGreaterThan(Money $other): bool
    {
        return $this->cents > $other->cents;
    }

    public function isLessThan(Money $other): bool
    {
        return $this->cents < $other->cents;
    }

    public function jsonSerialize(): int
    {
        return $this->cents;
    }

    public function toFloat(): float
    {
        return $this->cents / 100;
    }

    public static function fromFloat(float $amount): self
    {
        return new self((int) round($amount * 100));
    }

    public function formatted(string $locale = 'pt_BR', string $currency = 'BRL'): string
    {
        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($this->toFloat(), $currency);
    }

    public function __toString(): string
    {
        return $this->formatted();
    }
}