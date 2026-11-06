# Laravel Scheduler Setup Guide

## Development

```bash
# Jalankan scheduler manual untuk testing
php artisan schedule:run

# Atau jalankan terus-menerus (development)
php artisan schedule:work
```

## Production (Cron)

Tambahkan ke crontab server:

```bash
# Edit crontab untuk user www-data atau user aplikasi
sudo crontab -u www-data -e
```

Tambahkan baris ini:

```bash
* * * * * cd /var/www/html/karteng && php artisan schedule:run >> /dev/null 2>&1
```

Atau dengan logging:

```bash
* * * * * cd /var/www/html/karteng && php artisan schedule:run >> /var/www/html/karteng/storage/logs/scheduler.log 2>&1
```

## Verifikasi Cron

```bash
# Cek cron berjalan
sudo tail -f /var/log/syslog | grep CRON

# Atau cek log scheduler
tail -f /var/www/html/karteng/storage/logs/scheduler.log
```

## Scheduled Commands yang Direkomendasikan

Tambahkan di `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule): void
{
    // Hapus donasi pending lebih dari 7 hari
    $schedule->command('donations:cleanup-pending')->daily()->at('02:00');

    // Kirim reminder donasi pending
    $schedule->command('donations:send-reminders')->daily()->at('09:00');

    // Generate laporan bulanan
    $schedule->command('reports:monthly')->monthlyOn(1, '03:00');

    // Backup database (jika pakai spatie/laravel-backup)
    $schedule->command('backup:run')->daily()->at('01:00');

    // Clear cache lama
    $schedule->command('cache:clear')->daily()->at('04:00');

    // Optimize database
    $schedule->command('db:optimize')->weekly()->sundays()->at('03:00');
}
```

## Custom Commands untuk Aplikasi

### 1. Cleanup Donasi Pending

```bash
php artisan make:command CleanupPendingDonations
```

### 2. Send Donation Reminders

```bash
php artisan make:command SendDonationReminders
```

### 3. Monthly Report

```bash
php artisan make:command GenerateMonthlyReport
```

## Monitoring

```bash
# Cek scheduled tasks
php artisan schedule:list

# Test run specific command
php artisan schedule:run --force
```

## Best Practices

1. **Gunakan `withoutOverlapping()`** untuk mencegah job berjalan bersamaan
2. **Set `onOneServer()`** jika pakai multiple server
3. **Gunakan `runInBackground()`** untuk long-running tasks
4. **Log output** untuk debugging
5. **Set timezone** di `app/Console/Kernel.php`:
   ```php
   protected function schedule(Schedule $schedule): void
   {
       $schedule->timezone('Asia/Jakarta');
       // ...
   }
   ```