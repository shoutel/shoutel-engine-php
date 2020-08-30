var lang = {
  'comm_name_not_entered': '커뮤니티 이름을 입력하지 않았습니다.',
  'comm_id_not_entered': '커뮤니티 ID를 입력하지 않았습니다.',
  'description_not_entered': '커뮤니티 소개를 입력하지 않았습니다.',
  'comm_name_so_long': '커뮤니티 이름이 너무 깁니다.',
  'comm_id_so_long': '커뮤니티 ID가 너무 깁니다.',
  'description_so_long': '커뮤니티 소개가 너무 깁니다.',
  'comm_id_not_valid': '커뮤니티 ID에 허용되지 않은 문자가 포함되어 있습니다.',
  'board_already_exists': '이미 존재하는 게시판 ID 입니다.',
  'community_inserted': '커뮤니티가 생성되었습니다.'
};

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
        alert(lang[m]);
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
      try {
        var json_data = JSON.parse(data);
        var m = json_data.message;
      } catch (e) {
        alert(data);
        return;
      }

      if (m)
      {
        alert(lang[m]);
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
