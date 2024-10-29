(function($){
  var eos_apic_post_types = eos_apic.post_types.split(','),n=0;
  for(n;n<eos_apic_post_types.length;++n){
    wp.customize('eos_apic_' + eos_apic_post_types[n],function(value){
      value.bind(function(id){
        var body = $('body');
        body.append('<a id="eos-apic-new-url" href="' + eos_apic.home_url + '?p=' + id + '"></a>');
        $('#eos-apic-new-url').trigger('click');
      });
    });
  }
})(jQuery);
