var shoutel = {
  formSerialize: function(el) {
    var sa = $(el).serializeArray();
    var object = {};
    for (var i = 0; i < sa.length; i++){
      object[sa[i]['name']] = sa[i]['value'];
    }

    return object;
  }
};
