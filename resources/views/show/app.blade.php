
@if (strpos(request()->path(),'tz_admin/show') !== false)
<iframe id="admin_iframe" style="width: 100%;" frameborder="0" src="/admin{{ explode('tz_admin/show',request()->path())[1] }}?{{ http_build_query(request()->except(['_pjax'])) }}"></iframe>
@elseif (strpos(request()->path(),'tz_admin') !== false)
<iframe id="admin_iframe" style="width: 100%;" frameborder="0" src="/admin"></iframe>
@endif
<script type="text/javascript">
    $("#admin_iframe").height($(window).height()-120);
</script>
<!-- <div id="root_element">
</div>
<script>
    try {
        if(document.querySelectorAll('head > style').length) {
            document.querySelectorAll('head > style').forEach(function(item) {
                document.head.removeChild(item);
            });
        }
        let libScript = document.querySelector('script[src*="ddl/lib.js"]');
        let script2 = document.createElement("script");
        script2.type="text/javascript";
        script2.src="/ddl/lib.js?version="+Math.ceil(Math.random()*1000);
        document.body.replaceChild(script2,libScript);
        script2.onload = function() {
            let myScript = document.querySelector('script[src*="tz_assets/bundle.js"]');
            let script = document.createElement("script");
            script.type="text/javascript";
            script.src="/tz_assets/bundle.js?version="+Math.ceil(Math.random()*1000);
            document.body.replaceChild(script,myScript);
        }
    } catch(e) {
        console.warn(e);
    }
</script> -->
