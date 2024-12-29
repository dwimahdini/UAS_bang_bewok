<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Produk;
use App\Mail\ExpiringProductsNotification;
use Carbon\Carbon;

class SendExpiringProductsNotification extends Command
{
    protected $signature = 'notify:expiring-products';
    protected $description = 'Send notification about products approaching their expiration date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $thresholdInDays = 30; // Define the threshold for "approaching expiration"

        $products = Produk::where('tanggal_kadaluarsa', '<=', Carbon::now()->addDays($thresholdInDays))
                          ->where('tanggal_kadaluarsa', '>', Carbon::now())
                          ->get();

        if ($products->isEmpty()) {
            $this->info('No products approaching expiration.');
            return;
        }

        Mail::to('admin@example.com')->send(new ExpiringProductsNotification($products));

        $this->info('Notification about expiring products sent successfully.');
    }
}