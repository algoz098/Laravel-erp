
<script src="{{ asset('js/pushy.min.js') }}"></script>
<!--<script src="{{ asset('js/lists.min.js') }}"></script>-->
<!-- Scripts -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
