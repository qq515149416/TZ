var i = 0;
$("#pjax-container").on("pjax:success",function(data, status, xhr, options) {
    console.log(data,status, xhr, options);
});
