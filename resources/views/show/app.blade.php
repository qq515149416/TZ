<div id="root_element">
</div>
<script>
    try {
        let myScript = document.querySelector('script[src*="tz_assets/bundle.js"]');
        let script = document.createElement("script");
        script.type="text/javascript";
        script.src="/tz_assets/bundle.js?version="+Math.ceil(Math.random()*1000);
        document.body.replaceChild(script,myScript);
        if(document.querySelectorAll('style').length) {
            document.querySelectorAll('style').forEach(function(item) {
                document.head.removeChild(item);
            });
        }
    } catch(e) {
        console.warn(e);
    }
</script>
