# Queue Worker Setup Guide

## Development (Local)

```bash
# Jalankan queue worker di terminal terpisah
php artisan queue:work --tries=3 --timeout=90

# Atau untuk development dengan restart otomatis
php artisan queue:listen --tries=3 --timeout=90
```

## Production (Systemd Service)

Buat file `/etc/systemd/system/laravel-queue-worker.service`:

```ini
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
Group=www-data
Restart=always
RestartSec=3
WorkingDirectory=/var/www/html/gumelarn
ExecStart=/usr/bin/php artisan queue:work --sleep=3 --tries=3 --timeout=90 --max-jobs=1000 --max-time=3600

[Install]
WantedBy=multi-user.target
```

Enable dan start:
```bash
sudo systemctl daemon-reload
sudo systemctl enable laravel-queue-worker
sudo systemctl start laravel-queue-worker
sudo systemctl status laravel-queue-worker
```

## Supervisor Alternative (Lebih Recommended untuk Production)

Install supervisor:
```bash
sudo apt-get install supervisor
```

Buat `/etc/supervisor/conf.d/laravel-worker.conf`:
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/gumelarn/artisan queue:work --sleep=3 --tries=3 --timeout=90 --max-jobs=1000
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/html/gumelarn/storage/logs/worker.log
stdout_logfile_maxbytes=10MB
```

Reload supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl status laravel-worker:*
```

## Monitoring Queue

```bash
# Cek jobs pending
php artisan queue:monitor --max-size=100

# Cek failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush
```

## Queue Configuration (config/queue.php)

Pastikan `database` queue dikonfigurasi:
```php
'connections' => [
    'database' => [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
    ],
    ...
],
```

## Job yang Sudah Ada di Aplikasi

- `SendDonationConfirmationEmail` - Email konfirmasi donasi
- `SendMemberApprovalEmail` - Email approval/reject anggota
- `GenerateKtaPdf` - Generate PDF KTA di background
- `ProcessBulkImport` - Import massal data anggota

## Best Practices

1. **Gunakan `--timeout`** untuk mencegah job hang
2. **Set `--max-jobs`** untuk restart worker berkala (prevent memory leak)
3. **Gunakan `after_commit`** untuk memastikan DB transaction selesai sebelum job diproses
4. **Monitor failed jobs** secara berkala
5. **Gunakan `numprocs > 1`** untuk parallel processing