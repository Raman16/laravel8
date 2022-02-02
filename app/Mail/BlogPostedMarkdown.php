<?php
namespace App\Mail;
use App\Models\BlogPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class BlogPostedMarkdown extends Mailable  {
    use Queueable, SerializesModels;
    public $post;
    public function __construct(BlogPost $post) {
        $this->post = $post;
    }
    public function build() {
        return $this->subject('New Blog Posted')
                    ->markdown('emails.posts.blogposted-markdown');
    }
}
