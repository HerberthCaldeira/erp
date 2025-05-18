<?php

namespace App\Livewire;

use App\Models\Coupon;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateCoupon extends Component
{
    #[Validate('required')]
    public $status = 'enable';

    #[Validate('required')]
    public $code;

    #[Validate('required')]
    public $type = 'fixed';

    #[Validate('required')]
    public $value;

    #[Validate('required')]
    public $starts_at;

    #[Validate('required')]
    public $expires_at;

    public function updatedValue($value)
    {      
        // Remover caracteres não numéricos
        $value = preg_replace('/[^0-9]/', '', $value);

        // Remover zeros à esquerda para evitar acúmulos indesejados
        $value = ltrim($value, '0');

        // Se o usuário ainda não digitou nada, garantir "00.00"
        if ($value === '') {
            $value = '00.00';
        }

        // Se houver apenas um dígito, adicionar zeros à esquerda
        if (strlen($value) == 1) {
            $value = '00' . $value;
        } elseif (strlen($value) == 2) {
            $value = '0' . $value;
        }

        // Inserir ponto decimal corretamente
        $this->value = substr($value, 0, -2) . '.' . substr($value, -2);
        $floatValue = floatval($this->value);
        if ($this->type === 'percent' && $floatValue > 100) {
            $this->addError('value', 'Percentage cannot be more than 100.');
        } elseif ($this->type === 'fixed' && $floatValue < 0) {
            $this->addError('value', 'Value cannot be negative.');
        }

    }

    public function save()
    {
        $this->validate();

        $coupon = new Coupon();
        $coupon->status = $this->status;
        $coupon->code = $this->code;
        $coupon->type = $this->type;
        $coupon->value = $this->value;
        $coupon->starts_at = $this->starts_at;
        $coupon->expires_at = $this->expires_at;
        $coupon->save();

        $this->reset();

        $this->dispatch('notify', ['message' => 'Cupom criado com sucesso!']);
        
    }

    public function render()
    {
        return view('livewire.create-coupon');
    }
}
