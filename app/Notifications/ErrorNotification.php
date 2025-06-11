<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class ErrorNotification extends Notification
{
    use Queueable;

    /**
     * Données de l'erreur
     */
    private array $errorData;

    /**
     * Créer une nouvelle instance de notification
     *
     * @param array $errorData
     */
    public function __construct(array $errorData)
    {
        $this->errorData = $errorData;
    }

    /**
     * Obtenir les canaux de notification
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail', 'slack'];
    }

    /**
     * Obtenir la représentation mail de la notification
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->error()
            ->subject('Erreur Critique - ' . config('app.name'))
            ->line("Une erreur est survenue dans l'application.")
            ->line("Code d'erreur: {$this->errorData['code']}")
            ->line("Message: {$this->errorData['message']}")
            ->line("Sévérité: {$this->errorData['severity']}")
            ->line("URL: {$this->errorData['request']['url']}")
            ->line("Méthode: {$this->errorData['request']['method']}")
            ->line("IP: {$this->errorData['request']['ip']}")
            ->line("Fichier: {$this->errorData['file']}")
            ->line("Ligne: {$this->errorData['line']}")
            ->action('Voir les détails', url('/admin/errors'));
    }

    /**
     * Obtenir la représentation Slack de la notification
     *
     * @param mixed $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->error()
            ->content("Une erreur est survenue dans l'application")
            ->attachment(function ($attachment) {
                $attachment
                    ->title($this->errorData['message'])
                    ->fields([
                        'Code' => $this->errorData['code'],
                        'Sévérité' => $this->errorData['severity'],
                        'URL' => $this->errorData['request']['url'],
                        'Méthode' => $this->errorData['request']['method'],
                        'IP' => $this->errorData['request']['ip'],
                        'Fichier' => $this->errorData['file'],
                        'Ligne' => $this->errorData['line']
                    ]);
            });
    }
} 