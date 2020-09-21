function marketingPolicy()
{
  var modal = $('#marketingPolicyModal');
  if (!modal.hasClass('is-active'))
  {
    modal.addClass('is-active');
  }
  else
  {
    modal.removeClass('is-active');
  }
}


$('#joinForm').submit(function(e) {
  e.preventDefault();

  var form = shoutel.formSerialize(this);
  var url = $(this).attr('action');
  var req_data = JSON.stringify(form);

  $.ajax({
    type: 'POST',
    url: url,
    contentType: 'application/json',
    data: req_data,
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
        if (o) location.href = '/auth/' + o.next_step;
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
