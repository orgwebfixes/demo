<div class="content">
    <div class="title">Something went wrong.</div>    
    @unless(empty($sentryID))
    <!-- Sentry JS SDK 2.1.+ required -->
    <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

    <script>
        Raven.showReportDialog({
            eventId: '{{ $sentryID }}',
            // use the public DSN (dont include your secret!)
            dsn: 'https://5e3b53a09e14497baad96332a30c2319@sentry.io/98330'
        });
    </script>
    @endunless
</div>