function joinNextStep()
{
  if (!$('#terms_agree').is(':checked'))
  {
    alert('이용약관에 동의하셔야 합니다.');
    return false;
  }

  if (!$('#privacy_agree').is(':checked'))
  {
    alert('개인정보처리방침에 동의하셔야 합니다.');
    return false;
  }

  shoutel.addCsrfTokenElement();
  $('#joinAgreementForm').submit();
}
