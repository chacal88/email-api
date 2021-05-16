<?php

declare(strict_types=1);

namespace App\Application\Http\Controllers;

use App\Application\Jobs\StartProcessJob;
use App\Domain\Mailer\EmailToSend;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class EmailController extends Controller
{
    public function send(Request $request): JsonResponse
    {
        $this->validate(
            $request,
            [
                'from'    => 'required|email',
                'to'      => 'required|email',
                'cc.*'    => 'nullable|email',
                'format'  => 'nullable|in:markdown,html,text',
                'subject' => 'required',
                'body'    => 'required'
            ]
        );

        if(is_string($request->get('cc'))){
            $cc = explode(',', $request->get('cc'));
        }

        if(is_array($request->get('cc'))){
            $cc = $request->get('cc');
        }

        $emailToSend = new EmailToSend(
            Uuid::uuid4(),
            $request->get('from')?? 'html',
            $request->get('to'),
            $cc ?? [],
            $request->get('subject'),
            $request->get('body'),
            $request->get('format')
        );
        $job = (new StartProcessJob($emailToSend));

        dispatch($job);

        return response()->json($emailToSend->toArray(), 202);
    }
}
