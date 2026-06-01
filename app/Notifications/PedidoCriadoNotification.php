<?php

namespace App\Notifications;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PedidoCriadoNotification extends Notification
{
    use Queueable;

    public function __construct(public Pedido $pedido)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $clienteNome = optional($this->pedido->cliente)->nome;

        return (new MailMessage)
            ->subject("Confirmação do pedido #{$this->pedido->id}")
            ->greeting($clienteNome ? "Olá, {$clienteNome}!" : 'Olá!')
            ->line('Seu pedido foi criado com sucesso.')
            ->line('Número do pedido: ' . $this->pedido->id)
            ->line('Valor total: R$ ' . number_format((float) $this->pedido->total, 2, ',', '.'))
            ->line('Status atual: ' . ($this->pedido->status ?? 'pendente'))
            ->action('Ver detalhes do pedido', url('/'))
            ->line('Obrigado por comprar com a gente!');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pedido_id' => $this->pedido->id,
        ];
    }
}

