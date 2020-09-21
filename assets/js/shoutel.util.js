var shoutel = {
  formSerialize: function(el) {
    var sa = $(el).serializeArray();
    var object = {};
    for (var i = 0; i < sa.length; i++){
      object[sa[i]['name']] = sa[i]['value'];
    }

    return object;
  },
  addCsrfTokenElement: function() {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var csrf_el = document.createElement("input");
    $(csrf_el).attr({
      type: 'hidden',
      name: '_sht_csrf_token',
      value: csrf_token
    });
    $("form").append(csrf_el);
  }
};

$('button[type="submit"], input[type="submit"]').click(function() {
  shoutel.addCsrfTokenElement();
});
