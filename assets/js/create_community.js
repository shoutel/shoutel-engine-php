$('#createCommunityForm').submit(function(e) {
  e.preventDefault();

  var form = shoutel.formSerialize(this);
  var url = $(this).attr('action');

  $.ajax({
    type: 'PUT',
    url: url,
    contentType: 'application/json',
    data: JSON.stringify(form),
    success: function(data)
    {
      try {
        var json_data = JSON.parse(data);
        var m = json_data.message;
      } catch (e) {
        alert(data);
        return;
      }

      var o = json_data.output;

      if (m)
      {
        alert(m);
        if (o) location.href = '/c/' + o.comm_id;
        return;
      }
      else
      {
        alert('error');
        return;
      }
    },
    error: function(request)
    {
      var data = request.responseText;
      try {
        var json_data = JSON.parse(data);
        var m = json_data.message;
      } catch (e) {
        alert(data);
        return;
      }

      if (m)
      {
        alert(m);
        return;
      }
      else
      {
        alert('error');
        return;
      }
    }
  });
});
