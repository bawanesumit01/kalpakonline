<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    protected $signature   = 'mail:test {to? : Email address to send to}';
    protected $description = 'Send a test email to verify SMTP configuration';

    public function handle(): int
    {
        $to = $this->argument('to') ?? config('mail.from.address');

        $this->info("Sending test email to: {$to}");
        $this->info('SMTP Host  : ' . config('mail.mailers.smtp.host'));
        $this->info('SMTP Port  : ' . config('mail.mailers.smtp.port'));
        $this->info('SMTP User  : ' . config('mail.mailers.smtp.username'));
        $this->info('From       : ' . config('mail.from.address'));
        $this->newLine();

        try {
            Mail::raw(
                "Hello!\n\nThis is a test email from Kalpak Online.\n\nSMTP is configured and working correctly.\n\nHost: " . config('mail.mailers.smtp.host'),
                function ($message) use ($to) {
                    $message->to($to)
                            ->subject('Kalpak Online — SMTP Test ✅ ' . now()->format('H:i:s'));
                }
            );

            $this->info('✅ Email sent successfully! Check your inbox.');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Email failed: ' . $e->getMessage());
            $this->newLine();
            $this->line('<fg=yellow>Common fixes:</>');
            $this->line('  • For Gmail: use an App Password, not your account password');
            $this->line('    → myaccount.google.com/security → App passwords');
            $this->line('  • Make sure 2-Step Verification is enabled on your Google account');
            $this->line('  • Check MAIL_USERNAME and MAIL_PASSWORD in .env');
            return Command::FAILURE;
        }
    }
}
