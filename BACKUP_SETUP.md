# Database Backup Strategy

## Opsi 1: Spatie Laravel Backup (Recommended)

Install:
```bash
composer require spatie/laravel-backup
php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
php artisan migrate
```

Konfigurasi `config/backup.php`:
```php
return [
    'backup' => [
        'name' => env('APP_NAME', 'laravel-backup'),
        'source' => [
            'files' => [
                'include' => [
                    base_path(),
                ],
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                    base_path('storage/logs'),
                    base_path('storage/framework/cache'),
                    base_path('storage/framework/sessions'),
                    base_path('storage/framework/views'),
                ],
                'followLinks' => false,
            ],
            'databases' => [
                'sqlite',
            ],
        ],
        'databaseDumpCompressor' => null,
        'destination' => [
            'local' => 'backups',
        ],
        'temporaryDirectory' => storage_path('app/backup-temp'),
        'password' => env('BACKUP_PASSWORD'),
        'encryption' => 'openssl',
    ],
    'notifications' => [
        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailed::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFound::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailed::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessful::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFound::class => ['mail'],
        ],
        'mail' => [
            'to' => env('BACKUP_NOTIFICATION_EMAIL', 'admin@domain.com'),
        ],
    ],
    'monitorBackups' => [
        [
            'name' => env('APP_NAME', 'laravel-backup'),
            'disks' => ['local'],
            'healthChecks' => [
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumSizeInMegabytes::class => 5000,
            ],
        ],
    ],
    'cleanup' => [
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,
        'defaultStrategy' => [
            'keepAllBackupsForDays' => 7,
            'keepDailyBackupsForDays' => 16,
            'keepWeeklyBackupsForWeeks' => 8,
            'keepMonthlyBackupsForMonths' => 4,
            'keepYearlyBackupsForYears' => 2,
            'deleteOldestBackupsWhenUsingMoreMegabytesThan' => 5000,
        ],
    ],
];
```

Setup `.env`:
```env
BACKUP_PASSWORD=your-strong-password
BACKUP_NOTIFICATION_EMAIL=admin@nugumelar.or.id
```

Schedule di `app/Console/Kernel.php`:
```php
$schedule->command('backup:run')->daily()->at('01:00');
$schedule->command('backup:clean')->daily()->at('02:00');
$schedule->command('backup:monitor')->daily()->at('03:00');
```

## Opsi 2: Manual Script (Simple)

Buat script `backup-db.sh`:

```bash
#!/bin/bash
# Backup SQLite Database

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/www/html/gumelarn/storage/backups"
DB_PATH="/var/www/html/gumelarn/database/database.sqlite"
BACKUP_FILE="${BACKUP_DIR}/database_${DATE}.sqlite.gz"

# Buat direktori backup
mkdir -p "${BACKUP_DIR}"

# Backup dengan compression
sqlite3 "${DB_PATH}" .dump | gzip > "${BACKUP_FILE}"

# Hapus backup lebih dari 30 hari
find "${BACKUP_DIR}" -name "database_*.sqlite.gz" -mtime +30 -delete

# Log
echo "[$(date)] Backup completed: ${BACKUP_FILE}" >> "${BACKUP_DIR}/backup.log"
```

Make executable:
```bash
chmod +x backup-db.sh
```

Cron:
```bash
0 1 * * * /var/www/html/gumelarn/backup-db.sh
```

## Opsi 3: Laravel S3 Backup (Cloud Storage)

Install:
```bash
composer require spatie/laravel-backup
composer require league/flysystem-aws-s3-v3
```

Konfigurasi `filesystems.php`:
```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
],
```

Update `config/backup.php`:
```php
'destination' => [
    's3' => 'backups',
],
```

## Restore Database

### Dari Spatie Backup:
```bash
# List backups
php artisan backup:list

# Restore specific backup
php artisan backup:restore 2024-01-15_01-00-00
```

### Dari Manual Script:
```bash
# Extract dan restore
gunzip -c storage/backups/database_20240115_010000.sqlite.gz | sqlite3 database/database.sqlite
```

## Best Practices

1. **Test Restore Bulanan** - Jangan percaya backup sampai test restore
2. **Off-site Storage** - Simpan backup di lokasi terpisah (S3, Google Drive, dll)
3. **Enkripsi** - Selalu enkripsi backup sensitif
4. **Monitoring** - Setup alert jika backup gagal
5. **Retention Policy** - Tentukan berapa lama backup disimpan
6. **Backup Sebelum Deploy** - Selalu backup sebelum deployment besar

## Disaster Recovery Checklist

- [ ] Backup database harian
- [ ] Backup files (storage, .env) mingguan
- [ ] Test restore bulanan
- [ ] Dokumentasi prosedur restore
- [ ] Contact person untuk emergency
- [ ] RTO (Recovery Time Objective) < 1 jam
- [ ] RPO (Recovery Point Objective) < 24 jam