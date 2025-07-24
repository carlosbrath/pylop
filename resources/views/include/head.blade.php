<link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<!-- <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet"> -->
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css">

<script data-search-pseudo-elements="" defer=""
    src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "GovernmentOrganization",
  "name": "AJK Small Industries",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('/assets/img/public/logo.png') }}",
  "description": "Prime Minister Youth Loan Program for AJK Small Industries Development",
}
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-25NGL3V2R4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-25NGL3V2R4');
</script>
