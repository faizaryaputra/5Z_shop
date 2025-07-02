<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Models\Order;

class WhatsAppController extends Controller
{
    public function sendWhatsAppNotification(Order $order)
    {
        // Konfigurasi Twilio dari .env
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_FROM');

        // Inisialisasi Twilio Client
        $client = new Client($twilioSid, $twilioToken);

        // Pesan yang akan dikirim ke pelanggan
        $message = "Hi {$order->user->name}, your order #{$order->id} has been received. "
            . "Total: Rp " . number_format($order->total_price, 2) . ". Thank you for ordering at our Cafe Shop!";

        // Kirim pesan ke WhatsApp pelanggan
        $client->messages->create(
            'whatsapp:' . $order->user->phone, // Nomor WhatsApp pelanggan
            [
                'from' => $twilioWhatsAppNumber,
                'body' => $message
            ]
        );

        return back()->with('success', 'WhatsApp notification sent successfully!');
    }
}
