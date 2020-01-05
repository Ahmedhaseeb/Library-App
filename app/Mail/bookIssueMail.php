<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class bookIssueMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->data = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ahmedhaseeb123@gmail.com')
                ->subject($this->data['subject'])
                ->view('mail.bookIssueMail')
                ->with([
                    'subject' => $this->data['subject'],
                    'name' => $this->data['name'],
                    'return_date' => $this->data['return_date'],
                    'issue_date' => $this->data['issue_date'],
                    'msg' => $this->data['msg'],
                ]);
    }
}
