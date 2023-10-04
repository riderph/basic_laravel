<?php

namespace App\Mail;

use Illuminate\Support\Facades\Mail;

class RegisterUserSuccessEmail extends Mailable
{

    /**
     * Email send changed password
     *
     * @var string
     */
    protected $email;

    /**
     * Name of manager
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new message instance.
     *
     * @param string $email Email
     * @param string $name  Name
     *
     * @return void
     */
    public function __construct(string $email, string $name)
    {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'name' => $this->name,
        ];

        $mail = [
            'subject' => 'Create user successfully.',
            'to' => $this->email,
        ];
        Mail::send('emails.create-user-success', $data, function ($message) use ($mail) {
            $message->subject($mail['subject'])
                ->to($mail['to']);
        });
    }
}
