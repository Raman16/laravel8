<?php

namespace App\Mail;

use App\Models\BlogPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class BlogPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BlogPost $bp)
    {
        $this->post = $bp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@laravel.test', 'Admin')
            ->subject('New Blog Posted')
            // ->attach(storage_path('app/public').'/prof1.jpeg',
            //   [
            //     'as'=>'profile_picture.jpeg',
            //     'mime'=>'image/jpeg'
            //   ]
            //   )
             //Below attachFromStorage takes path from Storage class path
             //->attachFromStorage('prof1.jpeg','profile_picture.jpeg')
             ->attachData(Storage::get('prof1.jpeg'),'profile_picture_from_data.jpeg',
                  [
                    'mime'=>'image/jpeg'
                  ])
            ->view('emails.posts.newpost', ['post' => $this->post]);
    }
}
