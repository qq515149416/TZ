<div id="root_element">
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
</script>
