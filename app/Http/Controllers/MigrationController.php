<?php

namespace App\Http\Controllers;

use App\Mail\WebEmailClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

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
    function testEmail(){ 
        $data = [
            'subject' => 'Live Stock OTP',
            'otp'=> '123456789',
            'view' => 'emails.otp',
        ];
        Mail::to('ahsandanish.rad@gmail.com')->send(new WebEmailClass($data));
        return response()->json(['message' => 'Email sent successfully']);
    }
}
