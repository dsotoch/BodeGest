<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManagerStatic as Image;

class EnviarComprobante extends Mailable
{
    use Queueable, SerializesModels;
    private $empresa;
    private $imagen;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($empresa, $imagen)
    {
        $this->empresa = $empresa;
        $this->imagen = $imagen;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: 'bodegest@viru-tec.com',
            subject: 'Comprobante de Venta',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.comprobante',
            with: ['empresa' => $this->empresa]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $ima=$this->imagen;
        $im = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $ima));
       $imagen_reconstruida = imagecreatefromstring($im);
        $attachment = Attachment::fromData(function () use ($imagen_reconstruida) {
            ob_start();
            imagepng($imagen_reconstruida);
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }, "Comprobante.png");
       imagedestroy($imagen_reconstruida);
        return [$attachment];
    }
}
