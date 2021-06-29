<?php

namespace App\Jobs;

use App\Mail\MailNotify;
use App\Mail\MailNotifyOldVersion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailAmazon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $customers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $customers)
    {
        $this->data = $data;
        $this->customers = $customers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->data['type'] == 1) {
            foreach ($this->customers as $customer) {
                Mail::to($customer->email)->send(new MailNotify($this->data, $customer));
            }
        } elseif ($this->data['type'] == 2) {
            foreach ($this->customers as $customer) {
                Mail::to($customer->email)->send(new MailNotifyOldVersion($this->data, $customer));
            }
        }
    }
}
