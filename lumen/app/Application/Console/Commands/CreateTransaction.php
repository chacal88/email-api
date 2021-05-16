<?php


namespace App\Application\Console\Commands;


use App\Application\Jobs\StartProcessJob;
use App\Domain\Mailer\EmailToSend;
use Illuminate\Console\Command;
use Illuminate\Validation\Validator;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;
use Ramsey\Uuid\Uuid;

class CreateTransaction extends Command
{
    use ProvidesConvenienceMethods;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "email:start-transaction";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "request a new email";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $from = $this->ask('from?');
        $to = $this->ask('to?');
        $format = $this->ask('format?');
        $subject = $this->ask('subject?');
        $body = $this->ask('body?');

        if(is_string($this->ask('cc?'))){
            $cc = explode(',', $this->ask('cc?'));
        }

        if(is_array($this->ask('cc?'))){
            $cc = $this->ask('cc?');
        }

        $emailToSend = new EmailToSend(
            Uuid::uuid4(),
            $from,
            $to,
            $cc ?? [],
            $subject,
            $body,
            $format ?? 'text'
        );
        $job = (new StartProcessJob($emailToSend));

        dispatch($job);
    }
}
