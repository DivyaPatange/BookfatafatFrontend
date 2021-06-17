<script type="application/x-javascript"> 
addEventListener("load", function() { 
    setTimeout(hideURLbar, 0); }, false);
	function hideURLbar(){ window.scrollTo(0,1); 
} 
</script>

<!-- js -->
<script type="text/javascript" src="{{ asset('frontasset/js/jquery-2.1.4.min.js') }}"></script>
<!-- //js -->

<!-- single -->
<script src="{{ asset('frontasset/js/imagezoom.js') }}"></script>
<script src="{{ asset('frontasset/js/jquery.flexslider.js') }}"></script>
<!-- single -->

<!-- cart -->
<script src="{{ asset('frontasset/js/simpleCart.min.js') }}"></script>
<!-- cart -->
<!-- for bootstrap working -->
<script type="text/javascript" src="{{ asset('frontasset/js/bootstrap-3.1.1.min.js') }}"></script>

<script src="{{ asset('frontasset/js/jquery.easing.min.js') }}"></script>

<!-- Slide Description Image Area (316 x 328) -->
<script type="text/javascript" src="{{ asset('frontasset/js/pignose.layerslider.js') }}"></script>
<script type="text/javascript">
//<![CDATA[
    $(window).load(function() {
        $('#visual').pignoseLayerSlider({
            play    : '.btn-play',
            pause   : '.btn-pause',
            next    : '.btn-next',
            prev    : '.btn-prev'
        });
    });
//]]>
</script>


<!-- product-nav -->
<script src="{{ asset('frontasset/js/easyResponsiveTabs.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#horizontalTab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion           
        width: 'auto', //auto or any width like 600px
        fit: true   // 100% fit in a container
    });
});
</script>