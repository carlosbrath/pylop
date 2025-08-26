<?php

namespace App\Http\Controllers;

use App\Mail\WebEmailClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MigrationController extends Controller
{
    public function runMigrations(Request $request)
    {
        // Optional: Add some kind of security, such as a token or IP restriction
        $token = $request->input('token');
        if ($token !== config('app.migration_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Artisan::call('migrate', ['--force' => true]);
        // Artisan::call('db:seed', [
        //     '--class' => 'RoleSeeder',
        // ]);
        // return response()->json(['success' => 'Seeding Succefully ran successfully']);
        return response()->json(['success' => 'Migrations ran successfully']);
    }
    public function runComposer(Request $request)
    {
        $token = $request->input('token');
        if ($token !== config('app.migration_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Run composer install
        $process = new Process(['composer', 'install']);
        $process->setWorkingDirectory(base_path()); // Laravel project root
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json([
            'success' => 'Composer install ran successfully',
            'output' => $process->getOutput(),
        ]);
    }
    function testEmail()
    {
        $data = [
            'subject' => 'Live Stock OTP',
            'otp' => '123456789',
            'view' => 'emails.otp',
        ];
        Mail::to('ahsandanish.rad@gmail.com')->send(new WebEmailClass($data));
        return response()->json(['message' => 'Email sent successfully']);
    }
    function configClear()
    {
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return "✅ Laravel caches cleared!";
    }
}
