# Cron configuration

## Add cron jobs to root user

```bash
sudo crontab -u root -e
```

## Synchronization cron jobs

```bash
# bieblo-sync-availability cron every 15 minutes between 06:00-21:00
*/15 06-21 * * * php /opt/bieblo-server/bin/console sync:availability >> /var/log/bieblo-sync-availability.log

# bieblo-sync-run cron weekly on Monday morning at 01:00
00 01 * * 1 php /opt/bieblo-server/bin/console sync:run >> /var/log/bieblo-sync-run.log
```

